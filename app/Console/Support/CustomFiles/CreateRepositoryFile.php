<?php

namespace App\Console\Support\CustomFiles;

class CreateRepositoryFile
{
    public function __invoke(string $path, string $modelName): string
    {

        return "<?php

namespace App\Repositories\\$path;

use App\Repositories\BaseRepository;
use App\Models\\$path\\$modelName;

class {$modelName}Repository extends BaseRepository
{
    /**
     * @var Model
     */
    protected \$model = {$modelName}::class;
}";
    }
}
