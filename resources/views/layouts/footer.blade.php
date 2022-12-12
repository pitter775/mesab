<footer class="footer footer-black  footer-white ">
    <div class="container-fluid">
        <div class="row">
            <div class="credits ml-auto">
                <span class="copyright">
                    ©
                    <script>
                            <?php
                                use Illuminate\Support\Facades\Session;
                                $dados =  explode(",", session('message'));$icon = '';
                                if($dados[0] == 'Erro'){ $icon = 'danger';}else{$icon = 'info';}
                                if(session('message')){
                                    echo 'window.onload = function () {';
                                    echo "demo.showNotification('top','center', '".$icon."', '".session('message')."');";
                                    echo ' };';
                                }
                                Session::forget('message');
                            ?>
                        document.write(new Date().getFullYear())
                    </script>{{ __(', made with ') }}<i class="fa fa-heart heart"></i>{{ __(' by ') }}<a class="@if(Auth::guest()) text-white @endif" href="http://www.jhe.com.br/" target="_blank">JHE</a>
                </span>
            </div>
        </div>
    </div>
</footer>