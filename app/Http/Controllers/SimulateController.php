<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DateTime;

class SimulateController extends Controller
{
    public function __construct(
    ) {
    }

    /** 
     * View to simulate operations
     */
    public function index() {
        return view('simulate');
    }

    /**
     * Test operations simulation
     * 
     * @param Request $request
     */
    function test(Request $request) {
        
        if ($request->hasFile('cotacoes') && $request->file('cotacoes')->isValid()) {
            $fileCotacoes = $request->file('cotacoes')->path();
        } else {
            dd('error not found');
        }

        if ($request->hasFile('operacoes') && $request->file('operacoes')->isValid()) {
            $fileOperacoes = $request->file('operacoes')->path();
        } else {
            dd('error not found');
        }
        
        $historicalDataRaw = $this->readCSV($fileCotacoes); // Substitua 'path/to/your/csvfile.csv' pelo caminho correto do seu arquivo
        $operationsRaw  = $this->readCSV($fileOperacoes);
        
        $operations = $this->structureOperations($operationsRaw);

        // Estruturar os dados para fácil acesso por data e hora
        $historicalData = $this->structureHistoricalData($historicalDataRaw);

        // Agora, o $historicalData está pronto para ser usado na função simulateOperations.
        $results = $this->simulateOperations($historicalData, $operations);

        if (empty($results)) {
            return 'sem resultados';
        }

        $this->createCsv($results);
    }

    function readCSV($filename) {
        $rows = [];
        if (($handle = fopen($filename, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ";"); // Lê os cabeçalhos (primeira linha)
            
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $rows[] = array_combine($header, $data); // Associa os cabeçalhos com os dados
            }
            fclose($handle);
        }
        return $rows;
    }

    public function createResult($operation, $date, $time, $result, $closingPrice) {
        return [
            'TICKER' => $operation['TICKER'],
            'data' => $date,
            'horario' => $operation['horario'],
            'resultado' => $result,
            'closingPrice' => $closingPrice,
            'fechamento' => $operation['fechamento'],
            'tipo' => $operation['tipo'],
            'stop' => $operation['stop'],
            'gain' => $operation['gain'],
            'stop_horario' => $operation['stop_horario'],
            'shares' => $operation['shares'],
            'horario_fechamento' => $time
        ];
    }

    function simulateOperations($historicalData, $operations) {
        $results = [];
       
        foreach ($operations as $operation) {
            $date = DateTime::createFromFormat('d/m/Y', $operation['data']);
            $dateInitial = DateTime::createFromFormat('d/m/Y', $operation['data']);
            $ticker = $operation['TICKER'];
            $buyPrice = $operation['fechamento'];
            $horarioFechamento = $operation['stop_horario'];
            $result = null;
            $closingPrice = null;
            $deu = false;
            $shares = $operation['shares']; // 10 ações por operação.

            if ($operation['tipo'] === "Compra") {
                while (isset($historicalData[$ticker][$date->format('Y-m-d')])) {
                    foreach ($historicalData[$ticker][$date->format('Y-m-d')] as $time => $data) {
                        // se for no msm dia, verifica se o horario é menor que o da operacao
                        if ($date->format('Y-m-d') == $dateInitial->format('Y-m-d')
                            && $time < $operation['horario']) {
                            continue;
                        } else if (!empty($horarioFechamento) // se tiver fechamendo, verifica se nao é maior
                            && $date->format('Y-m-d') == $dateInitial->format('Y-m-d')
                            && $time > $horarioFechamento
                        ){
                            continue;
                        }

                        $closingPrice = $data['fechamento'];
                        $result = ($closingPrice - $buyPrice) * $shares; // usado para quando tem horario de fechamento

                        if ($closingPrice <= $operation['stop'] || $closingPrice >= $operation['gain']) {
                            if ($closingPrice >= $operation['gain']) {
                                $result = ($operation['gain'] - $buyPrice) * $shares; // usa o valor do stop
                            } else {
                                $result = ($operation['stop'] - $buyPrice) * $shares;
                            }

                            $results [] = $this->createResult($operation, $date->format('Y-m-d'), $time, $result, $closingPrice);
                            //$results[] = ['TICKER' => $ticker, 'data' => $date->format('Y-m-d'), 'horario' => $time , 'resultado' => $result];
                            $deu = true;
                            break;
                        }
        
                    }
                    
                    // se tiver horario de fechamento, nao passa pro proximo dia
                    if (!empty($horarioFechamento)) {
                        $results [] = $this->createResult($operation, $date->format('Y-m-d'), $horarioFechamento, $result, $closingPrice);
                        break;
                    }

                    $date->modify('+1 day');
                    if (!empty($deu)) {
                        break;
                    }
                }
            } elseif ($operation['tipo'] === "Venda") {
                while (isset($historicalData[$ticker][$date->format('Y-m-d')])) {
                    foreach ($historicalData[$ticker][$date->format('Y-m-d')] as $time => $data) {
                        if ($date->format('Y-m-d') == $dateInitial->format('Y-m-d')
                            && $time < $operation['horario']) {
                            //echo $time . ' ' . $operation['horario'] . '<br>';
                            continue;
                        } else if (!empty($horarioFechamento)
                            && $date->format('Y-m-d') == $dateInitial->format('Y-m-d')
                            && $time > $horarioFechamento
                        ){
                            continue;
                        }

                        $closingPrice = $data['fechamento'];
                        $result = ($closingPrice - $buyPrice) * $shares;
                    
                        if ($closingPrice >= $operation['stop'] || $closingPrice <= $operation['gain']) {
                            if ($closingPrice >= $operation['gain']) {
                                $result = ($operation['gain'] - $buyPrice) * $shares;
                            } else {
                                $result = ($operation['stop'] - $buyPrice) * $shares;
                            }
                            $results [] = $this->createResult($operation, $date->format('Y-m-d'), $time, $result, $closingPrice);
                            $deu = true;
                            break;
                        }
                    }
                    
                    // se tiver horario de fechamento, nao passa pro proximo dia
                    if (!empty($horarioFechamento)) {
                        $results [] = $this->createResult($operation, $date->format('Y-m-d'), $horarioFechamento, $result, $closingPrice);
                        break;
                    }

                    $date->modify('+1 day');
                    if (!empty($deu)) {
                        break;
                    }
                }
            }
        }
    
        return $results;
    }

    public function getCsv() {
        
    }

    function createCsv($operations) {
        // Cabeçalho do CSV
        $header = "TICKER;data;horario;fechamento/abertura operacao;tipo;quantidade acoes;preco stop loss;preco alvo/gain;horario fechamento da operacao;resultado;lucro/prejuizo;horario maximo fechar operacoes";

        // Criando o conteúdo do CSV
        $csvContent = $header . "\n";  // Adiciona o cabeçalho

        foreach ($operations as $operation) {
            $line = [
                $operation['TICKER'],
                $operation['data'],
                $operation['horario'] ?? '',  // Usando null coalescing para tratar valores não definidos
                $operation['fechamento'] ?? '',  // fechamento/abertura operacao
                $operation['tipo'] ?? '',  // tipo
                $operation['shares'] ?? '',  // quantidade acoes
                $operation['stop'] ?? '',  // preco stop loss
                $operation['gain'] ?? '',  // preco alvo/gain
                $operation['horario_fechamento'] ?? '',  // horario fechamento da operacao
                $operation['closingPrice'] ?? '',
                $operation['resultado'],  // lucro/prejuizo
                $operation['stop_horario'] ?? ''   // horario maximo fechar operacoes
            ];
            $csvContent .= implode(';', $line) . "\n";  // Convertendo o array em uma string e adicionando ao CSV
        }
        
        // Definindo os cabeçalhos para download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=operations.csv');
        
        // Exibindo o conteúdo do CSV
        echo $csvContent;
        
        redirect('/');

    }

    function structureOperations($operationsRaw) {
        $operations = [];
        foreach ($operationsRaw as $operation) {
            $operations[] = $this->transformOperation($operation);
        }

        return $operations;
    }

    public function transformOperation($original) {
        return [
            'TICKER' => $original['TICKER'],
            'data' => $original['data'],
            'horario' => $original['horario'],
            'fechamento' => floatval(trim($original['fechamento/abertura operacao'])),
            'tipo' => $original['tipo'],
            'stop' => floatval(trim($original['preco stop loss'])),
            'gain' => floatval(trim($original['preco alvo/gain'])),
            'stop_horario' => $original['horario maximo fechar operacoes'],
            'shares' => $original['numero acoes']
        ];
    }

    /** */
    function structureHistoricalData($historicalDataRaw) {
        $historicalData = [];
        foreach ($historicalDataRaw as $row) {
            $date = \DateTime::createFromFormat('d/m/Y', $row['data'])->format('Y-m-d');
            $time = $row['horario'];
            
            if (!isset($historicalData[$row['TICKER']][$date])) {
                $historicalData[$row['TICKER']][$date] = [];
            }
            $historicalData[$row['TICKER']][$date][$time] = $row;
        }

        return $historicalData;
    }


    function checkPriceDate ($data, $date){
        if (isset($data["Time Series (Daily)"][$date])) {
            $stockData = $data["Time Series (Daily)"][$date];
            $closePrice = $stockData["4. close"];

            return $closePrice;
        } else {
            return false;
        }
    }
}
