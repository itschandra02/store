@extends('admin.layouts.layout')
@section('title')
    Chats
@endsection
@section('content')
    <div class="row mb-5 pt-5">
        <div class="col">
            <div class="card m-b-0">
                <!-- .chat-row -->
                <div class="chat-main-box">
                    <!-- .chat-left-panel -->
                    <div class="chat-left-aside">
                        <div class="open-panel"><i class="ti-angle-right"></i></div>
                        <div class="chat-left-inner">
                            <div class="form-material">
                                <input class="form-control p-20" type="text" placeholder="Search Contact">
                            </div>
                            <ul class="chatonline style-none ">
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/1.jpg" alt="user-img"
                                            class="img-circle"> <span>Varun Dhavan <small
                                                class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="active"><img src="../assets/images/users/2.jpg"
                                            alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small
                                                class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/3.jpg" alt="user-img"
                                            class="img-circle"> <span>Ritesh Deshmukh <small
                                                class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/4.jpg" alt="user-img"
                                            class="img-circle"> <span>Arijit Sinh <small
                                                class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/5.jpg" alt="user-img"
                                            class="img-circle"> <span>Govinda Star <small
                                                class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/6.jpg" alt="user-img"
                                            class="img-circle"> <span>John Abraham<small
                                                class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/7.jpg" alt="user-img"
                                            class="img-circle"> <span>Hritik Roshan<small
                                                class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/8.jpg" alt="user-img"
                                            class="img-circle"> <span>Pwandeep rajan <small
                                                class="text-success">online</small></span></a>
                                </li>
                                <li class="p-20"></li>
                            </ul>
                        </div>
                    </div>
                    <!-- .chat-left-panel -->
                    <!-- .chat-right-panel -->
                    <div class="chat-right-aside">
                        <div class="chat-main-header">
                            <div class="p-20 b-b">
                                <h3 class="box-title">Chat Message</h3>
                            </div>
                        </div>
                        <div class="chat-rbox">
                            <ul class="chat-list p-20">
                                <!--chat Row -->
                                <li>
                                    <div class="chat-img"><img src="../assets/images/users/1.jpg" alt="user" /></div>
                                    <div class="chat-content">
                                        <h5>James Anderson</h5>
                                        <div class="box bg-light-info">Lorem Ipsum is simply dummy text of the printing &
                                            type setting industry.</div>
                                    </div>
                                    <div class="chat-time">10:56 am</div>
                                </li>
                                <!--chat Row -->
                                <li>
                                    <div class="chat-img"><img src="../assets/images/users/2.jpg" alt="user" /></div>
                                    <div class="chat-content">
                                        <h5>Bianca Doe</h5>
                                        <div class="box bg-light-info">It’s Great opportunity to work.</div>
                                    </div>
                                    <div class="chat-time">10:57 am</div>
                                </li>
                                <!--chat Row -->
                                <li class="reverse">

                                    <div class="chat-content">
                                        <h5>Steave Doe</h5>
                                        <div class="box bg-light-inverse">It’s Great opportunity to work.</div>
                                    </div>
                                    <div class="chat-img"><img src="../assets/images/users/5.jpg" alt="user" /></div>
                                    <div class="chat-time">10:57 am</div>
                                </li>
                                <!--chat Row -->
                                <li class="reverse">

                                    <div class="chat-content">
                                        <h5>Steave Doe</h5>
                                        <div class="box bg-light-inverse">It’s Great opportunity to work.</div>
                                    </div>

                                    <div class="chat-img"><img src="../assets/images/users/5.jpg" alt="user" /></div>
                                    <div class="chat-time">10:57 am</div>
                                </li>
                                <!--chat Row -->
                                <li>
                                    <div class="chat-img"><img src="../assets/images/users/3.jpg" alt="user" /></div>
                                    <div class="chat-content">
                                        <h5>Angelina Rhodes</h5>
                                        <div class="box bg-light-info">Well we have good budget for the project</div>
                                    </div>
                                    <div class="chat-time">11:00 am</div>
                                </li>
                                <!--chat Row -->
                            </ul>
                        </div>
                        <div class="card-body b-t">
                            <div class="row">
                                <div class="col-lg-10 col-sm-10">
                                    <textarea placeholder="Type your message here" class="form-control b-0"></textarea>
                                </div>
                                <div class="col-lg-2 col-sm-2 text-right">
                                    <button type="button" class="btn btn-info btn-circle btn-lg"><i
                                            class="fas fa-paper-plane"></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .chat-right-panel -->
                </div>
                <!-- /.chat-row -->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            "use strict";

            $('.chat-left-inner > .chatonline').slimScroll({
                height: '100%',
                position: 'right',
                size: "5px",
                color: '#dcdcdc'

            });
            $('.chat-list').slimScroll({
                position: 'right',
                size: "5px",
                height: '100%',
                color: '#dcdcdc'
            });

            var cht = function() {
                var topOffset = 445;
                var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
                height = height - topOffset;
                $(".chat-list").css("height", (height) + "px");
            };
            $(window).ready(cht);
            $(window).on("resize", cht);



            // this is for the left-aside-fix in content area with scroll
            var chtin = function() {
                var topOffset = 270;
                var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
                height = height - topOffset;
                $(".chat-left-inner").css("height", (height) + "px");
            };
            $(window).ready(chtin);
            $(window).on("resize", chtin);

            $(".open-panel").on("click", function() {
                $(".chat-left-aside").toggleClass("open-pnl");
                $(".open-panel i").toggleClass("ti-angle-left");
            });
        });
    </script>
@endsection
