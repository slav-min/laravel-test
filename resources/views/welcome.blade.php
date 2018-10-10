<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                /* height: 100vh; */
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

<!--                 <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div> -->
                <div>
                <?php
                
                    $url = 'http://phisix-api3.appspot.com/stocks.json';
                    $res = getData($url);
                    echo makeTable($res);
                
                
                
                function getData($url){
                    
                    if (function_exists('curl_init')) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL,$url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,14);
                        curl_setopt($ch, CURLOPT_HEADER,0);
                        $response = curl_exec($ch);
                        curl_close($ch);
                    } else {
                        $response = @file_get_contents($url);
                    }
                    
                    return $response;
                    
                }

                function makeTable($data){
                    $dataArr = json_decode($data, true);
                    $out = '<div style="text-align:right; margin-bottom:20px"><button onclick="update()">Update</button></div>';
                    $out.= '<table class="table table-striped">';
                    $out.='<tr><th>NAME</th><th>PRICE</th><th>CHANGE</th><th>VOLUME</th><th>SYMBOL</th></tr>';
                    foreach ($dataArr['stock'] as $k=>$v){
                        $out.='<tr>';
                        if($v['name']){
                            $out.= '<td>'.$v['name'].'</td>';
                        }
                        if($v['percent_change']){
                            $out.= '<td>'.$v['percent_change'].'</td>';
                        }
                        if($v['volume']){
                            $out.= '<td>'.$v['volume'].'</td>';
                        }
                        if($v['symbol']){
                            $out.= '<td>'.$v['symbol'].'</td>';
                        } 
                         if($v['price']){
                            $out.= '<td>'.$v['price']['currency'].' / '.$v['price']['amount'].'</td>';
                        }                         
                    }
                    $out.='</tr>';
                    $out.='</table>';

                    return $out;                    
                }

                ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            setTimeout(function(){
               location = '/public/'
            },15000);
            function update(){
               location = '/public/'
            }
       </script>
    </body>
</html>
