<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Styles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/js/all.min.js"
        integrity="sha512-cyAbuGborsD25bhT/uz++wPqrh5cqPh1ULJz4NSpN9ktWcA6Hnh9g+CWKeNx2R0fgQt+ybRXdabSBgYXkQTTmA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .child-box {
            border: 1px solid rgba(174, 174, 174, 0.5);
            margin-bottom: 18px;
            border-radius: 7px !important;
        }

        .child-box:hover {
            border: 1px solid #ec7f00;
        }

        .child-box .header {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: space-between;
            align-items: center;
            padding: 11px 15px;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            cursor: pointer;
            position: relative;
        }

        .child-box .header .left {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: flex-start;
            align-items: center;
        }

        .child-box .header .left img {
            height: 20px;
            margin-right: 12px;
        }

        .child-box .short-payment-support-info {
            background: rgba(174, 174, 174, 0.713);
            padding: 11px 15px;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: flex-end;
            align-items: center;
            cursor: pointer;
            border-bottom-left-radius: 7px;
            border-bottom-right-radius: 7px;
        }

        .child-box .short-payment-support-info img {
            height: 13px;
            margin-right: 7px;
        }

        .child-box .short-payment-support-info .open-button-action-payment {
            color: #414141;
            font-size: 13px;
            margin-left: 10px;
        }

        .child-box .button-action-payment {
            padding: 15px;
            display: none;
        }

        .button-action-payment ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            /* grid-template-columns: repeat(2, 1fr); */
            align-items: center;
            align-content: baseline;
        }

        .button-action-payment li {
            border: 1px solid #c7d0d7;
            padding: 10px;
            border-radius: 0.3em;
            margin-bottom: 10px;
            position: relative;
            display: list-item;
            text-align: -webkit-match-parent;
        }

        .button-action-payment li.disabled {
            cursor: no-drop;
            pointer-events: none;
        }

        .button-action-payment .info-top {
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            user-select: none;
        }

        .button-action-payment .info-top img {
            height: 20px;
            object-fit: contain;
        }

        .button-action-payment .info-top b {
            font-size: 12px;
            font-weight: 600;
        }

        .button-action-payment .info-bottom {
            font-size: 11px;
            color: #333232;
        }

        .button-action-payment .info-bottom b {
            font-weight: bolder;
        }

        .button-action-payment input[type="radio"] {
            display: none;
        }


        .button-action-payment input[type="radio"]+.list-group-item {
            cursor: pointer;
            background-color: #00000091;
            color: #dcddeb;
            border-color: transparent;
            font-size: 12px;
        }

        .button-action-payment input[type="radio"]+.list-group-item:before {
            /* content: "\2713"; */
            color: transparent;
            font-weight: bold;
            margin-right: 1em;
        }


        .button-action-payment input[type="radio"]:checked+.list-group-item {
            color: #2f2fd5;
        }

        .button-action-payment input[type="radio"]:checked+.list-group-item:before {
            color: inherit;
        }

    </style>
    <style>
        @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,700");
        @import url("https://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css");

        .cus-accordion {
            transform: translateZ(0);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        .cus-accordion>.accordion-toggle {
            position: absolute;
            opacity: 0;
            display: none;
        }

        .cus-accordion>label {
            position: relative;
            display: block;
            height: 50px;
            line-height: 50px;
            padding: 0 20px;
            font-size: 14px;
            font-weight: 700;
            border-top: 1px solid #ddd;
            background: #fff;
            cursor: pointer;
        }

        .cus-accordion>label:after {
            content: '\f078';
            position: absolute;
            top: 0px;
            right: 20px;
            font-family: fontawesome;
            transform: rotate(90deg);
            transition: .3s transform;
        }

        .cus-accordion>section {
            height: 0;
            transition: .3s all;
            overflow: hidden;
        }

        .cus-accordion>.accordion-toggle:checked~label:after {
            transform: rotate(0deg);
        }

        .cus-accordion>.accordion-toggle:checked~section {
            height: 200px;
        }

        .cus-accordion>section p {
            margin: 15px 0;
            padding: 0 20px;
            font-size: 12px;
            line-height: 1.5;
        }

    </style>
</head>

<body>
    <div class="cus-accordion">
        <input type="radio" class="accordion-toggle" name="toggle" id="toggle1">
        <label for="toggle1">
            Pure CSS Accordion 1
        </label>
        <section>
            <p>
                Bacon ipsum dolor sit amet beef venison beef ribs kielbasa. Sausage pig leberkas, t-bone sirloin
                shoulder bresaola. Frankfurter rump porchetta ham. Pork belly prosciutto brisket meatloaf short ribs.
            </p>
        </section>
    </div>

    <div class="cus-accordion">
        <input type="radio" class="accordion-toggle" name="toggle" id="toggle2">
        <label for="toggle2">
            Pure CSS Accordion 1
        </label>
        <section>
            <p>
                Bacon ipsum dolor sit amet beef venison beef ribs kielbasa. Sausage pig leberkas, t-bone sirloin
                shoulder bresaola. Frankfurter rump porchetta ham. Pork belly prosciutto brisket meatloaf short ribs.
            </p>
        </section>
    </div>
    <div class="area-list-payment-method">
        <div class="child-box payment-drawwer">
            <div class="header short-payment-support-info-head" onclick="openPaymentDrawer(this)">
                <div class="left">
                    <img src="https://semutganteng.fra1.digitaloceanspaces.com/UniPlay/68badd326c92daa50df9b43bd0b2c81c.png"
                        alt="Metode Pembayaran">
                    <b>Virtual Account</b>
                </div>
            </div>
            <div class="button-action-payment" style="display:none;">
                <ul>
                    <li>

                        <input type="radio" name="paymentMethod" id="paymentMethod-tripay-MYBVA" value="tripay-MYBVA"
                            data-fee="0" data-fee-percent="0">
                        <label for="paymentMethod-tripay-MYBVA" class="list-group-item">
                            <div class="info-top">
                                <img src="https://tripay.co.id/images/payment-channel/ZT91lrOEad1582929126.png">
                                <b id="payment">17.000</b>
                            </div>
                            <div class="info-bottom">
                                MYBVA
                            </div>
                        </label>
                    </li>
                    <li>

                        <input type="radio" name="paymentMethod" id="paymentMethod-tripay-PERMATAVA"
                            value="tripay-PERMATAVA" data-fee="0" data-fee-percent="0">
                        <label for="paymentMethod-tripay-PERMATAVA" class="list-group-item">
                            <div class="info-top">
                                <img src="https://tripay.co.id/images/payment-channel/szezRhAALB1583408731.png">
                                <b id="payment">17.000</b>
                            </div>
                            <div class="info-bottom">
                                PERMATAVA
                            </div>
                        </label>
                    </li>
                    <li>

                        <input type="radio" name="paymentMethod" id="paymentMethod-tripay-BNIVA" value="tripay-BNIVA"
                            data-fee="0" data-fee-percent="0">
                        <label for="paymentMethod-tripay-BNIVA" class="list-group-item">
                            <div class="info-top">
                                <img src="https://tripay.co.id/images/payment-channel/n22Qsh8jMa1583433577.png">
                                <b id="payment">17.000</b>
                            </div>
                            <div class="info-bottom">
                                BNIVA
                            </div>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="short-payment-support-info" onclick="openPaymentDrawer(this)">
                <img src="https://semutganteng.fra1.digitaloceanspaces.com/UniPlay/ab4d3b3c1c7064fe503f20c930ed14a9.png"
                    style="">
                <img src="https://semutganteng.fra1.digitaloceanspaces.com/UniPlay/5629c3172ab8bcc266ed06c3a2d33290.png"
                    style="">
                <img src="https://semutganteng.fra1.digitaloceanspaces.com/UniPlay/21a56d9c15d3c6a44845751b953ea713.png"
                    style="">
                <img src="https://semutganteng.fra1.digitaloceanspaces.com/UniPlay/ee96757e066b76a8ce9feb3c04d02650.png"
                    style="">
                <a class="open-button-action-payment">
                    <i class="fas fa-chevron-down"></i>
                </a>

                <span class="channel-not-available" style="display: none;">Tidak tersedia pembayaran pada channel
                    ini</span>
            </div>
        </div>
    </div>
    <script>
        function openPaymentDrawer(elem) {
            var $this = $(elem);


            $('.payment-drawwer').not(this).each(function() {
                var $parents = $(this);
                $parents.find('.button-action-payment').slideUp(function() {
                    $parents.removeClass('active');
                });

                $parents.find('.short-payment-support-info').find('img').fadeIn();
                $parents.find('.short-payment-support-info').find('i').removeClass('fa-chevron-up').addClass(
                    'fa-chevron-down');
            });

            var $parents = $this.parents('.child-box');

            // console.log('IsHidden', $parents.find('.button-action-payment').is(":hidden"));

            if (!$parents.find('.button-action-payment').is(":hidden")) {
                $parents.find('.button-action-payment').slideUp(function() {
                    $parents.removeClass('active');
                });

                $parents.find('.short-payment-support-info').find('img').fadeIn();
                $parents.find('.short-payment-support-info').find('.fa-chevron-up').removeClass('fa-chevron-up').addClass(
                    'fa-chevron-down');

            } else {
                $parents.find('.button-action-payment').slideDown(function() {
                    $parents.addClass('active');
                });
                $parents.find('.short-payment-support-info').find('img').fadeOut();
                $parents.find('.short-payment-support-info').find('.fa-chevron-down').addClass('fa-chevron-up').removeClass(
                    'fa-chevron-down');

            }
        }
    </script>
</body>

</html>
