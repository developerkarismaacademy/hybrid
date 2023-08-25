
<style>
    @import url('https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Telex&display=swap');

    * {
        font-family: 'Anybody', cursive;
        font-family: 'Telex', sans-serif;
    }

    .section-1 .content-section {
        text-align: center;
    }

    .section-kelas .container {
        position: absolute;
        left: 50%;
        transform: translate(-50%, -55%);

    }

    .section-kelas .title-box {
        background-color: #F26F27;
        border-radius: 8px;
        padding: 15px 75px;
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
    }

    .section-kelas .container .content {
        background-color: #FFF;
        box-shadow: 10px 4px 19px 5px rgba(0, 0, 0, 0.35);
        -webkit-box-shadow: 10px 4px 19px 5px rgba(0, 0, 0, 0.35);
        -moz-box-shadow: 10px 4px 19px 5px rgba(0, 0, 0, 0.35);
        border-radius: 12px;
        margin-top: 50px;
    }

    .section-kelas .card {
        border: none;
        border-radius: 40px;
        padding: 20px;
    }

    .section-kelas .card-img-top {
        border-radius: 12px;
        box-shadow: 11px 11px 23px -1px rgba(0, 0, 0, 0.35);
        -webkit-box-shadow: 11px 11px 23px -1px rgba(0, 0, 0, 0.35);
        -moz-box-shadow: 11px 11px 23px -1px rgba(0, 0, 0, 0.35);
    }

    .section-kelas .card .card-body {
        margin: 0;
    }

    .section-kelas .card .card-body .card-title {
        font-family: 'Anybody';
        font-style: normal;
        font-weight: 700;
        font-size: 24px;
        line-height: 161.5%;
        color: #F45400
    }

    .section-kelas .card .card-body .card-text {
        font-family: 'Anybody';
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 161.5%;
        color: #000000;
        margin-bottom: 0;
    }

    .section-tentang .content {
        padding: 50px;
    }


    .section-tentang .content .img-content {
        padding-left: 50px;
        padding-right: 50px;
        -webkit-filter: drop-shadow(5px 5px 5px #2222225e);
        filter: drop-shadow(5px 5px 5px #2222225e);
    }

    .section-skema {
        background-image: url('../img/Vector.png'), url('../img/Group\ 52.png');
        background-repeat: no-repeat;
        background-size: cover,contain;
        background-position: center,top;
        padding-top: 100px;
        padding-bottom: 100px;
        position: relative;
    }

    .section-skema .container {
        border: 1px solid #000000;
        border-radius: 10px;
        padding: 50px 60px;
        background-color: #FFFFFF;
    }

    .section-skema .container h1 {
        font-family: 'Anybody';
        font-style: normal;
        font-weight: 700;
        line-height: 54px;

        color: #13213B;

    }

    .section-skema .container p {
        width: 976px;
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        font-size: 1.6rem;
        color: #383838;
    }

    .section-skema .table-bordered tr,.section-skema .table-bordered td,.section-skema .table-bordered th{
        border: 1px solid #000000 !important;
    }

    .section-skema .table thead th {
        background: #F16B25;
        font-family: 'Anybody';
        font-style: normal;
        font-weight: 700;
        font-size: 20px;
        line-height: 21px;

        color: #FFFFFF;

        text-align: center;

    }

    .section-skema .table tbody tr td {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 27px;
        letter-spacing: 0.02em;

        color: #383838;

        text-align: left;

        padding: 30px;
    }

    .section-skema .container h4 {
        margin-top: 50px;
        margin-bottom: 50px;
        font-family: 'Anybody';
        font-style: normal;
        font-weight: 700;
        line-height: 33px;
        /* identical to box height */


        color: #13213B;

    }

    .section-skema .container .btn-table {
        position: absolute;
        bottom: 5%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #F16B25;
        border-radius: 10px;
        color: #FFFFFF;
        padding: 18px 72px;
        font-family: 'Anybody';
        font-style: normal;
        font-weight: 700;
        font-size: 1.6rem;
        line-height: 33px;

        color: #FFFFFF;
    }

    .section-syarat {
        background-repeat: no-repeat;
        background-size: cover, contain;
        background-position: center, top right;
        padding-top: 100px;
        padding-bottom: 100px;
        position: relative;

    }

    .section-syarat .container {
        border: 1px solid #000000;
        border-radius: 10px;
        padding: 25px;
        background-color: #FFFFFF;
    }


    .section-syarat .container table {
        margin-top: 10px;
    }

    .section-syarat .container tbody tr td {
        padding-bottom: 30px;


    }


    .clear{
        clear: both;
        margin: 5px;
    }


    /* utilities */
    section .btn {
        border-radius: 24px;
    }





    @media (min-width: 236px) {
        .section-1 {
            padding: 25px 0;
            height: 100%;
            background-image: url('../img/bg\ oren.png');
            background-position: center top;
            background-repeat: no-repeat;
            background-size: fill;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }
        .section-1 .img-section {
            width: 100%;
        }
        .section-1 .content-section h1 {
            font-family: 'Anybody';
            /*font-size: 54px;*/
            font-style: italic;
            font-weight: 500;
            line-height: 127.5%;
            font-size: 1rem;
            letter-spacing: 0.095em;
            color: #FFFFFF;
        }
        .section-1 .content-section p {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            font-family: 'Anybody';
            font-weight: 300;
            font-size: 1rem;
            line-height: 161.5%;
            color: #FFFFFF;
        }
        .section-1 .content-section .btn-new {
            color: #FFFFFF;
            font-family: 'Telex';
            font-style: normal;
            font-weight: 400;
            font-size: 1rem;
            /* identical to box height */
            text-align: center;
            letter-spacing: 0.035em;
            background: rgba(255, 150, 0, 0.18);
            border: 4px solid #FFFFFF;
            padding: 10px 27px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .section-tentang {
            background-image: url('../img/Vector.png'), url('../img/Group\ 46.png');
            background-repeat: no-repeat;
            background-size: cover, contain;
            background-position: center, left;
            margin: 40px 0;
        }
        .section-tentang .title-box {
            background-color: #F26F27;
            border-radius: 8px;
            padding: 15px 15px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
        .section-tentang h1 {
            margin: 0;
            padding: 0;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 1.6rem;
            line-height: 51px;
            color: #FFFFFF;
        }
        .section-tentang .content .content-desc {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 400;
            font-size: 1rem;
            line-height: 161.5%;
        }

        .section-tentang .content .content-slogan {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 1rem;
            line-height: 33px;
            color: #13213B;
        }
        .section-tentang .content {
            padding: 15px;
            background-color: white;
        }
        .section-kelas h1 {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 1.4rem;
            line-height: 51px;
            color: #FFFFFF;
            margin: 0;
            padding: 0;
        }
        .section-kelas {
            margin-top: 900px;
            padding-top: 50px;
            background-color: #F26F27;
            position: relative;
            height: 368px;
        }

        .section-kelas .container {
            position: absolute;
            left: 50%;
            transform: translate(-50%, -55%);

        }

        .section-kelas .title-box {
            background-color: #F26F27;
            border-radius: 8px;
            padding: 15px 35px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .section-kelas .container .content {
            background-color: #FFF;
            box-shadow: 10px 4px 19px 5px rgba(0, 0, 0, 0.35);
            -webkit-box-shadow: 10px 4px 19px 5px rgba(0, 0, 0, 0.35);
            -moz-box-shadow: 10px 4px 19px 5px rgba(0, 0, 0, 0.35);
            border-radius: 12px;
            margin-top: 50px;
        }

        .section-kelas .card {
            border: none;
            border-radius: 40px;
            padding: 20px;
        }

        .section-kelas .card-img-top {
            border-radius: 12px;
            box-shadow: 11px 11px 23px -1px rgba(0, 0, 0, 0.35);
            -webkit-box-shadow: 11px 11px 23px -1px rgba(0, 0, 0, 0.35);
            -moz-box-shadow: 11px 11px 23px -1px rgba(0, 0, 0, 0.35);
        }

        .section-kelas .card .card-body {
            margin: 0;
        }

        .section-kelas .card .card-body .card-title {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 161.5%;
            color: #F45400
        }

        .section-kelas .card .card-body .card-text {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 161.5%;
            color: #000000;
            margin-bottom: 0;
        }

        .section-skema {
            background-image: url('../img/Vector.png'), url('../img/Group\ 52.png');
            background-repeat: no-repeat;
            background-size: cover,contain;
            background-position: center,top;
            padding-top: 450px;
            padding-bottom: 100px;
            position: relative;
        }

        .section-skema .container {
            border: 1px solid #000000;
            border-radius: 10px;
            padding: 20px;
            background-color: #FFFFFF;
        }

        .section-skema .container h1 {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 600;
            line-height: 54px;
            color: #13213B;

        }

        .section-skema .container p {
            width: 100%;
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-size: 1rem;
            color: #383838;
        }

        .section-skema .table-bordered tr,.section-skema .table-bordered td,.section-skema .table-bordered th{
            border: 1px solid #000000 !important;
        }

        .section-skema .table thead th {
            background: #F16B25;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
            line-height: 21px;

            color: #FFFFFF;

            text-align: center;

        }

        .section-skema .table tbody tr td {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-size: 18px;
            line-height: 27px;
            letter-spacing: 0.02em;

            color: #383838;

            text-align: left;

            padding: 30px;
        }

        .section-skema .container h4 {
            margin-top: 50px;
            margin-bottom: 50px;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            line-height: 33px;
            /* identical to box height */


            color: #13213B;

        }

        .section-skema .container .btn-table {
            position: absolute;
            bottom: 2%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #F16B25;
            border-radius: 10px;
            color: #FFFFFF;
            padding: 18px 12px;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 1.2rem;
            line-height: 33px;
            width: 80%;
            color: #FFFFFF;
        }

        .section-syarat {
            background-repeat: no-repeat;
            background-size: cover, contain;
            background-position: center, top right;
            padding-top: 100px;
            padding-bottom: 100px;
            position: relative;

        }

        .section-syarat .container {
            border: 1px solid #000000;
            border-radius: 10px;
            padding: 25px;
            background-color: #FFFFFF;
        }

        .section-syarat .container h1 {
            background-color: #F16B25;
            width: 100%;
            padding: 20px 20px;
            border-radius: 8px;
            text-align: center;
            text-transform: capitalize;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 600;
            color: #FFFFFF;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 60px;
            font-size: 1.3rem;
        }

        .section-syarat .container table {
            margin-top: 10px;
        }

        .section-syarat .container tbody tr td {
            padding-bottom: 30px;


        }

        .section-syarat .container .number {
            float: left;
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-size: 40px;
            line-height: 60px;
            color: #FFCB05;
            height: 45.7px;
        }

        .clear{
            clear: both;
            margin: 35px;
        }

        .section-syarat .container .text {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-size: 1.2rem;
            line-height: 119%;
            /* or 29px */


            color: #383838;

        }

        .section-keuntungan {
            background-image: url('../img/Vector.png'), url('../img/bg54.png');
            background-repeat: no-repeat;
            background-size: cover, cover;
            background-position: center, top;
            padding-top: 50px;
        }

        .section-keuntungan .title-box {
            background-color: #F26F27;
            border-radius: 8px;
            padding: 22px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .section-keuntungan h1 {
            margin: 0;
            padding: 0;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            line-height: 51px;
            color: #FFFFFF;
            font-size: 1.3rem;
        }

        .section-keuntungan .content-desc {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 400;
            font-size: 1.1rem;
            line-height: 161.5%;
            margin: 40px 0;
            /* or 55px */
            text-align: center;
        }

        .section-keuntungan ul li {
            list-style-type: none;
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            color: #FFFFFF;
            width: 86%;
            margin: 20px 0;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

        }

        .section-keuntungan ul li:first-child {
            background-color: #F26F27;

        }

        .section-keuntungan ul li:nth-child(2) {
            background-color: #F26F27;
            /*margin-left: 30px;*/
        }

        .section-keuntungan ul li:last-child {
            background-color: #F26F27;
            /*margin-left: 60px;*/
        }

        .section-keuntungan img{
            width: 70%;
        }

        .section-keuntungan .ask{
            background-color: #F16B25;
            width: 100%;
            height: 145px;
            position: relative;
            padding: 40px 0;
        }

        .section-keuntungan .text{
            background-color: #ffffff;
            border-radius: 8px;
            border: 4px solid #F16B25;
            width: 90%;
            text-align: center;
            position: absolute;
            left: 50%;
            font-size: 1rem;
            padding: 3px;
            transform: translate(-50%, -55%);
        }

    }




    @media (min-width: 768px) {
        .section-1 {
            padding-top: 10%;
            height: 100vh;
            background-size: cover;
            border-bottom-left-radius: 22px;
            border-bottom-right-radius: 22px;
        }
        .section-1 .img-section {
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .section-1 .content-section h1 {
            font-size: 2.5rem;
        }
        .section-1 .content-section p {
            width: 80%;
            font-size: 2rem;
            margin-top: 40px;
        }
        .section-1 .img-section {
            width: 650px;
        }
        .section-1 .content-section .btn-new {
            margin-top: 50px;
            font-size: 2rem;
            line-height: 39px;
            padding: 17px 37px;
        }
        .section-tentang {
            background-image: url('../img/Vector.png'), url('../img/Group\ 46.png');
            background-repeat: no-repeat;
            background-size: cover, contain;
            background-position: center, left;
            padding: 3rem 0 !important;
            margin: 3rem 0 !important;
        }
        .section-tentang .title-box {
            background-color: #F26F27;
            border-radius: 8px;
            padding: 15px 50px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
        .section-tentang .content .content-desc {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 400;
            font-size: 1.6rem;
            line-height: 161.5%;
            /* or 55px */
            text-align: justify;
        }
        .section-tentang .content .content-slogan {
            padding-top: 20px;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 1.8rem;
            line-height: 33px;
            color: #13213B;
        }
        .section-tentang .content {
            padding: 50px;
            background-color: rgba(255, 255, 255, 0);
        }
        .section-kelas {
            margin-top: 300px;
        }

        .section-kelas .container {
            position: absolute;
            left: 50%;
            transform: translate(-50%, -55%);

        }

        .section-kelas .title-box {
            background-color: #F26F27;
            border-radius: 8px;
            padding: 15px 75px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .section-kelas .container .content {
            background-color: #FFF;
            box-shadow: 10px 4px 19px 5px rgba(0, 0, 0, 0.35);
            -webkit-box-shadow: 10px 4px 19px 5px rgba(0, 0, 0, 0.35);
            -moz-box-shadow: 10px 4px 19px 5px rgba(0, 0, 0, 0.35);
            border-radius: 12px;
            margin-top: 50px;
        }

        .section-kelas .card {
            border: none;
            border-radius: 40px;
            padding: 20px;
        }

        .section-kelas .card-img-top {
            border-radius: 12px;
            box-shadow: 11px 11px 23px -1px rgba(0, 0, 0, 0.35);
            -webkit-box-shadow: 11px 11px 23px -1px rgba(0, 0, 0, 0.35);
            -moz-box-shadow: 11px 11px 23px -1px rgba(0, 0, 0, 0.35);
        }

        .section-kelas .card .card-body {
            margin: 0;
        }

        .section-kelas .card .card-body .card-title {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 161.5%;
            color: #F45400
        }

        .section-kelas .card .card-body .card-text {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 161.5%;
            color: #000000;
            margin-bottom: 0;
        }

        .section-skema {
            background-image: url('../img/Vector.png'), url('../img/Group\ 52.png');
            background-repeat: no-repeat;
            background-size: cover,contain;
            background-position: center,top;
            padding-top: 100px;
            padding-bottom: 100px;
            position: relative;
        }

        .section-skema .container {
            border: 1px solid #000000;
            border-radius: 10px;
            padding: 50px 60px;
            background-color: #FFFFFF;
        }

        .section-skema .container h1 {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            line-height: 54px;

            color: #13213B;

        }

        .section-skema .container p {
            width: 976px;
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-size: 1.6rem;
            line-height: 62px;

            color: #383838;
        }

        .section-skema .table-bordered tr,.section-skema .table-bordered td,.section-skema .table-bordered th{
            border: 1px solid #000000 !important;
        }

        .section-skema .table thead th {
            background: #F16B25;
            padding: 30px 100px;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
            line-height: 21px;

            color: #FFFFFF;

            text-align: center;

        }

        .section-skema .table tbody tr td {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-size: 18px;
            line-height: 27px;
            letter-spacing: 0.02em;

            color: #383838;

            text-align: left;

            padding: 30px;
        }

        .section-skema .container h4 {
            margin-top: 50px;
            margin-bottom: 50px;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            line-height: 33px;
            /* identical to box height */


            color: #13213B;

        }

        .section-skema .container .btn-table {
            position: absolute;
            bottom: 5%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #F16B25;
            border-radius: 10px;
            color: #FFFFFF;
            padding: 18px 72px;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            font-size: 1.6rem;
            line-height: 33px;

            color: #FFFFFF;
        }

        .section-syarat {
            background-image: url('../img/Vector.png'), url('../img/Group\ 53.png');
            background-repeat: no-repeat;
            background-size: cover, contain;
            background-position: center, top right;
            padding-top: 100px;
            padding-bottom: 100px;
            position: relative;
            background-color: #F16B25;

        }

        .section-syarat .container {
            border: 1px solid #000000;
            border-radius: 10px;
            padding: 50px 60px;
            background-color: #FFFFFF;
        }

        .section-syarat .container h1 {
            background-color: #F16B25;
            width: 80%;
            padding: 20px 150px;
            border-radius: 8px;
            text-align: center;
            text-transform: capitalize;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            line-height: 51px;
            color: #FFFFFF;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 60px;
            font-size: 2rem;
        }

        .section-syarat .container table {
            margin-top: 10px;
        }

        .section-syarat .container tbody tr td {
            padding-bottom: 30px;


        }

        .section-syarat .container .number {
            float: left;
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-size: 40px;
            line-height: 60px;
            color: #FFCB05;
            height: 100px;
            display: flex;
            align-items: center;
        }

        .clear{
            clear: both;
            margin: 5px;
        }

        .section-syarat .container .text {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-size: 1.5rem;
            line-height: 119%;
            height: 100px;
            display: flex;
            align-items: center;
            /* or 29px */


            color: #383838;

        }

        .section-keuntungan {
            background-image: url('../img/Vector.png'), url('../img/bg54.png');
            background-repeat: no-repeat;
            background-size: cover, cover;
            background-position: center, top;
            padding-top: 50px;
        }

        .section-keuntungan .title-box {
            background-color: #F26F27;
            border-radius: 8px;
            padding: 22px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .section-keuntungan h1 {
            margin: 0;
            padding: 0;
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 700;
            line-height: 51px;
            color: #FFFFFF;
            font-size: 2rem;
        }

        .section-keuntungan .content-desc {
            font-family: 'Anybody';
            font-style: normal;
            font-weight: 400;
            font-size: 1.5rem;
            line-height: 161.5%;
            margin: 40px 0;
            /* or 55px */
            text-align: center;
        }

        .section-keuntungan ul li {
            list-style-type: none;
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            color: #FFFFFF;
            width: 75%;
            margin: 20px 0;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

        }

        .section-keuntungan ul li:first-child {
            background-color: #F26F27;

        }

        .section-keuntungan ul li:nth-child(2) {
            background-color: #F26F27;
            margin-left: 30px;
        }

        .section-keuntungan ul li:last-child {
            background-color: #F26F27;
            margin-left: 60px;
        }

        .section-keuntungan img{
            width: 70%;
        }

        .section-keuntungan .ask{
            background-color: #F16B25;
            width: 100%;
            height: 100px;
            position: relative;
            padding: 20px 0;
        }

        .section-keuntungan .text{
            background-color: #ffffff;
            border-radius: 8px;
            border: 4px solid #F16B25;
            width: 60%;
            text-align: center;
            position: absolute;
            left: 50%;
            font-size: 1.2rem;
            padding: 15px 50px;
            transform: translate(-50%, -55%);
        }


    }
</style>