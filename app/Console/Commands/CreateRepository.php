<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Support\CustomFiles\CreateRepositoryFile;

class CreateRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:create {path} {modelName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository file';

    private $modelName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->modelName = $this->argument('modelName');
        $this->path = $this->argument('path');

        if (empty($this->path)) {
            $this->newLine(2);
            return $this->info("O parâmetro 'path' é obrigatório, defina o banco antes de continuar");
        }

        $this->path = ucfirst($this->path);

        if ($this->modelName === 'all') {
            foreach (scandir("./app/Models/{$this->path}") as $modelName) {
                $this->createFiles($this->path, $modelName);
                $this->info("- - - - - - - - - ");
            }
        } else {
            $this->createFiles($this->path, $this->modelName);
        }

        $this->info("- - - - - - - - - E N D - - - - - - - - -");
        $this->info("Tudo pronto, seus arquivos foram criado com sucesso!");
    }

    private function createFiles(string $path, string $modelName)
    {
        $modelName = str_replace(['/', '\\', '.php', 'php'], '', $modelName);

        $this->info($modelName);

        $file = (array) $this->createRepository($path, $modelName);

        if (!file_exists("./app/Models/{$path}/{$modelName}.php")) {
            return $this->info("A model {$modelName} não existe");
        }

        if (!is_dir("./app/Repositories/{$path}")) {
            mkdir("./app/Repositories/{$path}");
        }

        $this->info("Criando o seu arquivo: {$path}/{$file['fileName']}");
        sleep(1);

        $pathToFile = $file['filePath'] . $file['fileName'];

        if (file_exists($pathToFile)) {
            $this->info("O arquivo {$file["fileName"]} já existe");
            return null;
        } else {
            if ($fileHandle = fopen($pathToFile, "a+")) {
                fwrite($fileHandle, $file["content"]);
                fclose($fileHandle);
            } else {
                $this->info("O arquivo {$file["fileName"]} não foi possível ser criado");
                return null;
            }
        }

        unset($pathToFile);
        unset($fileHandle);

        $this->info("O arquivo {$file["fileName"]} foi criado com sucesso");
        sleep(0.5);

        $this->info("- - - - - - - - - ");
    }

    private function createRepository(string $path, string $modelName): array
    {
        return [
            'fileName' => "{$modelName}Repository.php",
            'filePath' => "app/Repositories/{$path}/",
            'content' => (new CreateRepositoryFile())($path, $modelName),
        ];
    }
}
