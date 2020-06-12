<script type="text/javascript" src="/media/js/jquery-ui-1.8.1.custom.min.js"></script>
<script type="text/javascript" src="/media/js/underscore-min.js"></script>
<script type="text/javascript" src="/media/js/moment-with-locales.min.js"></script>
<!--  <script type="text/javascript" src="js/bootstrap.min.js"></script> -->
<script type="text/javascript" src="/media/js/bootstrap-datetimepicker.min.js"></script>
<style>
    .ui-autocomplete {
        background-color: white;
        width: 340px;
        border: 1px solid #cfcfcf;
        list-style-type: none;
        cursor: pointer;
        padding-left: 0px;
    }
    .ui-menu-item:hover {
        background-color: #f4f4f9;
    }
</style>

<div class="block map_viewer" id="map_viewer">
    <div align="center"><div id="map_canvas"></div></div>
</div>

<div class="block command_buttons">
    <div align="center">
        <div class="progress" style="display: none;">
            <div
                id="progressbar"
                class="progress-bar progress-bar-striped progress-bar-animated"
                role="progressbar"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100"
                style="width: 0%; display: none;"
            >
            </div>
        </div>
        <div id="buttons">
            <input class="form-control" id="search_radius" type="number" value="30" min="0" max="" step="30"/>
            <div class="btn-group">
                <button type="button" class="btn btn-info" onClick="searchPhoto()"><span class="glyphicon glyphicon-search"></span></button>
                <button type="button" class="btn btn-danger" onClick="clearMap()"><span class="glyphicon glyphicon-trash"></span> Очистить</button>
                <div class="btn-group dropup"><button type="button" class="btn btn-info dropdown-toggle" data-toggle="modal" data-target="#Date_Modal"><span class="glyphicon glyphicon-list-alt"></span></button></div>
                <button type="button" class="btn btn-info" onClick=""><span class="glyphicon glyphicon-cog"></span> Кол-во</button>
                <div class="btn-group dropup"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="modal" data-target="#Style_Modal"><span class="glyphicon glyphicon-fullscreen"></span></button></div>

                <button id="speedChanger" style="display: none;" type="button" class="btn btn-warning dropdown-toggle" id="speedClass" data-toggle="dropdown"><span class="glyphicon glyphicon-map-marker"></span> Скорость отслеживания</button>
                <ul class="dropdown-menu" role="menu">
                    <li><a class="speed_item" href="#fast_upd" id="fast_upd">Быстро</a></li>
                    <li><a class="speed_item" href="#default_upd" id="default_upd">Средне</a></li>
                    <li><a class="speed_item" href="#slow_upd" id="slow_upd">Медленно</a></li>
                </ul>
            </div>
            <div class="btn-group" role="group" aria-label="basic label">
                <p class="text-center" style="margin: 0 0 0px;">Отслеживание:</p>
            </div>
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default btn-xs">
                    <input type="radio" name="seek_location" id="seek_location_ok" value="1" />
                    <span class="glyphicon glyphicon-ok"></span>
                </label>
                <label class="btn btn-danger btn-xs active">
                    <input type="radio" name="seek_location" id="seek_location_off" value="0" />
                    <span class="glyphicon glyphicon-remove"></span>
                </label>
            </div>
        </div>
    </div>
</div>

<div id="result"></div>


<!-- Modal date-->
<div class="modal fade" id="Date_Modal" tabindex="-1" role="dialog" aria-labelledby="dateModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Выбор дат</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            Начальная дата:
                            <div class="input-group date" id="datetimepicker8">

                                <input type="text" class="form-control" id="start_time"/>
                                <span class="input-group-addon">
				  <span class="glyphicon glyphicon-calendar"></span>
				</span>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-xs-12">
                        <div class="form-group">
                            Конечная дата:
                            <div class="input-group date" id="datetimepicker9">

                                <input type="text" class="form-control" id="end_time"/>
                                <span class="input-group-addon">
				  <span class="glyphicon glyphicon-calendar"></span>
				</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" id="ok" class="btn btn-primary">Применить</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal date-->
<div class="modal fade" id="Style_Modal" tabindex="-1" role="dialog" aria-labelledby="styleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Выберите вид</h4>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-primary btn-lg btn-block" id="main">Основной</button>
                <button type="button" class="btn btn-success btn-lg btn-block" id="bigMap">Большая карта</button>
                <button type="button" class="btn btn-warning btn-lg btn-block" id="fullMap">Очень большая карта</button>
                <button type="button" class="btn btn-danger btn-lg btn-block" id="noneMap">Убрать карту</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary">Применить</button>
            </div>
        </div>
    </div>
</div>

<!-- HTML код диалогового окна-->
<div id="myModalonJS" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title">Фотография</h3>
            </div>
            <div class="modal-body">
                <img id="modal_image" src="">
            </div>
            <span>Ссылка на профиль: <a target="_blank" id="username" href=""></a></span><br>
            <span>Ссылка на оригинал: <a target="_blank" id="origin_img" href=""></a></span>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<div id="scrollup"><img src="media/images/up.png" class="up" alt="Прокрутить вверх" /></div>

<script type="text/javascript">
    $(function () {
        //Инициализация datetimepicker8 и datetimepicker9
        $("#datetimepicker8").datetimepicker({language: 'ru'});
        $("#datetimepicker9").datetimepicker({language: 'ru'});
        //При изменении даты в 8 datetimepicker, она устанавливается как минимальная для 9 datetimepicker
        $("#datetimepicker8").on("dp.change",function (e) {
            $("#datetimepicker9").data("DateTimePicker").setMinDate(e.date);
            //$("#start_time").val()
        });
        //При изменении даты в 9 datetimepicker, она устанавливается как максимальная для 8 datetimepicker
        $("#datetimepicker9").on("dp.change",function (e) {
            $("#datetimepicker8").data("DateTimePicker").setMaxDate(e.date);
            //$("#start_time").val()
        });
    });


    $('input[id=seek_location_ok]').on("change",function () {
        $(this).parent().toggleClass('btn-default').toggleClass('btn-success');
        $('[id=seek_location_off]').parent().toggleClass('btn-default').toggleClass('btn-danger');
        $('#speedChanger').css("display", "block");

    });

    $('input[id=seek_location_off]').on("change",function () {
        $(this).parent().toggleClass('btn-default').toggleClass('btn-danger');
        $('[id=seek_location_ok]').parent().toggleClass('btn-default').toggleClass('btn-success');
        $('#speedChanger').css("display", "none");

    });

    $('#main').on('click', function () {
        $('#map_canvas').css('height', '300px');
    });

    $('#bigMap').on('click', function () {
        $('#map_canvas').css('height', '600px');
    });

    $('#fullMap').on('click', function () {
        $('#map_canvas').css('height', '800px');
    });
    $('#noneMap').on('click', function () {
        $('#map_canvas').css('height', '0px');
    });
</script>