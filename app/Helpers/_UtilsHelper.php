<?php

/* DATE & TIME */
if (!function_exists('datetimeComplete')) {
    function datetimeComplete(?string $date): ?string
    {
        return !empty($date)
            ? date("d/m/Y - H:i:s", strtotime($date))
            : null;
    }
}

if (!function_exists('datetimeMini')) {
    function datetimeMini(?string $date): ?string
    {
        return !empty($date)
            ? date("d/m/y - H:i", strtotime($date))
            : null;
    }
}

/**
 * Função pra debug, printar a ultima query valida
 * Combines SQL and its bindings
 *
 * @param \Eloquent $query
 * @return string
 */
if (!function_exists('getEloquentSqlWithBindings')) {
    function getEloquentSqlWithBindings($query)
    {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            $binding = addslashes($binding);
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
}

if (!function_exists('datetimePeriod')) {
    function datetimePeriod($date, $time, $period = 'days', $type = '+')
    {
        if (empty($date)) {
            $date = date('Y-m-d H:i:s');
        }

        if (!is_numeric($time) || !in_array($period, ['seconds', 'minutes', 'hours', 'days', 'months', 'years'])) {
            return null;
        }

        // check date format to return
        if (str_contains($date, '-') && str_contains($date, ':')) {
            $format = 'Y-m-d H:i:s';
        } elseif (str_contains($date, '-')) {
            $format = 'Y-m-d';
        } elseif (str_contains($date, ':')) {
            $format = 'H:i:s';
        } else {
            return null;
        }

        // check if is to add or remove period
        $type = in_array($type, ['+', '-']) ? $type : '+';

        return date($format, strtotime("{$date} {$type}{$time} {$period}"));
    }
}

// retorna a data que passou, ex: 1 minuto atrás /ou/ agora
if (!function_exists('timeElapsedString')) {
    function timeElapsedString(string $datetime, bool $full = false) :string
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = [
            'y' => 'ano',
            'm' => 'mês',
            'w' => 'semana',
            'd' => 'dia',
            'h' => 'hora',
            'i' => 'minuto',
            's' => 'segundo',
        ];
        
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = "{$diff->$k} {$v}" . ($diff->$k > 1 ? ($k == 'm' ? 'es' : 's') : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
    
        return $string ? implode(', ', $string) . ' ' . 'atrás' : 'agora';
    }
}

// d/m/Y
if (!function_exists('dateComplete')) {
    function dateComplete(?string $date): ?string
    {
        return !empty($date)
            ? date("d/m/Y", strtotime($date))
            : null;
    }
}

// d/m/y
if (!function_exists('dateMini')) {
    function dateMini(?string $date): ?string
    {
        return !empty($date)
            ? date("d/m/y", strtotime($date))
            : null;
    }
}

// dd/mm/yyyy -> yyyy-mm-dd
if (!function_exists('dateDatabase')) {
    function dateDatabase(?string $date): ?string
    {
        return !empty($date)
            ? implode('-', array_reverse(explode('/', $date)))
            : null;
    }
}

if (!function_exists('dateValidate')) {
    function dateValidate($date): bool
    {
        if (empty($date)) {
            return false;
        }

        $date   = explode("-", $date); // fatia a string $dat em pedados, usando / como referência
        $d      = $date[2] ?? null;
        $m      = $date[1] ?? null;
        $y      = $date[0] ?? null;

        return (bool) checkdate($m, $d, $y);
    }
}

// Cria uma array de datas entre duas datas
if (!function_exists('createDateRangeArray')) {
    function createDateRangeArray($strDateFrom, $strDateTo)
    {
        $aryRange = [];

        $dateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $dateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($dateTo >= $dateFrom) {
            array_push($aryRange, date('Y-m-d', $dateFrom)); // first entry
            while ($dateFrom < $dateTo) {
                $dateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $dateFrom));
            }
        }

        return $aryRange;
    }
}

/* TIME */
if (!function_exists('timeComplete')) {
    function timeComplete(?string $date): ?string
    {
        return !empty($date)
            ? date("H:i:s", strtotime($date))
            : null;
    }
}

if (!function_exists('timeMini')) {
    function timeMini(?string $date): ?string
    {
        return !empty($date)
            ? date("H:i", strtotime($date))
            : null;
    }
}

/*  CURRENCY AND MONEY */
if (!function_exists('floatCurrency')) {
    function floatCurrency($value, $currency = 'R$')
    {
        if (empty($value) || !is_numeric($value)) {
            return false;
        }

        switch ($currency) {
            case 'R$':
            case 'R$ ':
            case 'BRL':
                $currency_position  = 'before';
                $value              = number_format($value, 2, ',', '.');
                break;
            default:
                $currency_position  = 'before';
                $value              = number_format($value, 2, '.', ',');
                break;
        }

        switch ($currency_position) {
            case 'before':
                return $currency . $value;
            break;
            case 'after':
                return $value . $currency;
            break;
            default:
                return $value;
            break;
        }
    }
}

/*  CURRENCY TO INPUT */
if (!function_exists('floatCurrentyInput')) {
    function floatCurrentyInput($value): string
    {
        if (empty($value) || !is_numeric($value)) {
            return "0,00";
        }

        return (string) number_format($value, 2, '.', ',');
    }
}

if (!function_exists('onlyNumbers')) {
    function onlyNumbers(string|int|float $string): string
    {
        return (string) preg_replace('/[^0-9]/', '', $string);
    }
}

/**
 * Retorna a imagem do S3 ou RackSpac já tratada
 */
function imagePathHelper(
    string $url,
    string $filename,
    int $size,
    int $wm = 0,
    ?string $crop = null
): string {
    if (is_null($crop)) {
        $url = str_replace('&crop={crop}', '', $url);
    }

    return str_replace(
        ['{filename}', '{size}', '{wm}', '{crop}'],
        [$filename, $size, $wm, $crop],
        $url
    );
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// ENVIA UM LOG PARA O DISCORD COM UMA MENSAGEM TRATADA
function sendDiscordWebook(string $message, ?string $type = null)
{
    $sendWebhook = new \Matmper\DiscordWebhook(
        config('discord.discord_webhook'),
        config('discord.discord_bot_name'),
        config('app.env'),
        config('app.name'),
    );

    return $sendWebhook->send($message, $type);
}

/**
 * Retorna a URL do Select Client já formatada
 *
 * @param string|null $uri
 * @param string|null $userToken
 * @param boolean|null $clean
 * @return string
 */
function baseUrlClient(?string $uri, ?string $userToken = null, ?bool $clean = false): string
{
    $url  = config('epics.url_epics_select_client');
    $url .= $uri;
    $url .= $userToken ? "?s={$userToken}" : '';

    return $clean ? str_replace(['http://', 'https://', 'www.'], '', $url) : $url;
}

/**
 * Retorna a URL de um checkout de um pedido
 *
 * @param string $pedidoToken
 * @param boolean|null $clean
 * @return string
 */
function baseUrlOrder(string $pedidoToken, ?bool $clean = false): string
{
    $url = config('epics.url_epics_store');
    $url .= 'pagar/pedido/';
    $url .= $pedidoToken;

    return $clean ? str_replace(['http://', 'https://', 'www.'], '', $url) : $url;
}

/**
 * Captura os get atuais e substitui pelos desejados
 *
 * @param array $params
 * @param string|null $url
 * @param boolean|null $unset
 * @return string
 */
function baseUrlGet(array $params = [], ?string $url = null, ?bool $unset = false): string
{
    $url = $url
        ? ($url === 'back' ? url()->previous() : url($url))
        : url()->current();
    
    if (str_contains($url, '?')) {
        $url = explode('?', $url);
        foreach (explode('&', $url[1]) as $u) {
            $explode = explode('=', $u);
            $params = [$explode[0] => ($explode[1] ?? null)] + $params;
        }
        $url = $url[0];
    }

    if (isset($_GET) && count($_GET) > 0) {
        $params = $_GET + $params;
    }

    if ($unset && isset($params['per_page'])) {
        unset($params['per_page']);
    }

    $params = is_array($params) && count($params) > 0 ? '?' . http_build_query($params) : '';

    return $url . $params;
}

/**
 * Remove os itens da primeira array caso contenha na segunda, sendo multidimensional
 *
 * @param array $arr1
 * @param array $arr2
 * @param string $field
 * @return array
 */
function arrayDiffMulti(array $arr1, array $arr2, string $field): array
{
    return array_filter($arr1, function ($arr) use ($arr2, $field) {
        if (empty($arr2)) {
            return true;
        }

        $arr = json_decode(json_encode($arr), true);
        $arr2 = json_decode(json_encode($arr2), true);

        foreach ($arr2 as $arr2value) {
            if ($arr[$field] == $arr2value[$field]) {
                return false;
            }
        }

        return true;
    });
}

/**
 * Converte uma array ou objeto e retorna tudo em array ou objeto
 *
 * @param array|object|null $array
 * @param bool $toArray             = true retorna array, false retorna objeto
 * @return object
 */
function countableConvert(array|object|null $item, bool $toArray = false): object|array|null
{
    if (is_null($item)) {
        return null;
    }
    
    return $toArray === true
        ? (array) json_decode(json_encode($item), true)
        : (object) json_decode(json_encode($item), false);
}
