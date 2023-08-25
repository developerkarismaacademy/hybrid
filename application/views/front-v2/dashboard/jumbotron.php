<!--JUMBOTRON-->
<section id="jumbotron" class="jumbotron jumbotron-fluid">
    <style>

        nav {
            margin:auto;
            text-align: center;
            width: 100%;
        }

        nav ul ul {
            display: none;
        }

        nav ul li:hover > ul{
            display: block;
            width: 170px;
            cursor : pointer;

        }

        nav ul {
            padding: 0 20px;
            list-style: none;
            position: relative;
            display: inline-table;
            width: 100%;
        }

        nav ul:after {
            content: "";
            clear:both;
            display: block;
        }

        nav ul li{
            float:left;
        }

        nav ul li:hover{
            cursor : pointer;

        }

        nav ul li:hover a{
            cursor : pointer;
            color:#fff;
        }

        nav ul li a{
            display: block;
            padding: 25px;
            color: #fff;
            text-decoration: none;
        }

        nav ul ul{
            border-radius: 0px;
            padding: 0;
            position: absolute;
            top: 2%;
            margin-left: -12%;
        }

        nav ul ul li{
            float:none;
            position: relative;
        }

        nav ul ul li a{
            padding: 15px 40px;
            color: #fff;
        }

        nav ul ul li a:hover{
            background-color: #666;
            cursor : pointer;
        }

        nav ul ul ul{
            position: absolute;
            left: 50%;
            top: 0;
        }
    </style>
    <a href="https://hybrid.karismaacademy.com/gamification">
        <nav>
            <ul class="fixed-bottom mr-5 mb-5 d-flex w-100">
<!--                <li class="ml-auto"><img class=" faa-pulse animated-hover" src="/assets/front/images/Frame.png" alt="karisma gold" width="75" >-->
<!--                    <ul>-->
<!--                        <li>-->
<!--                            <p class="text-center" style="width: 100%; font-weight: bold; border-radius: 10px;   padding: 12px 0; padding-left: 2%; margin-left: 3%; background-color: #FFD100; color: white;">Selesaikan Misi, Tukarkan Goldnya!</p>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
            </ul>
        </nav>
    </a>
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-sm-12 mt-5">
				<h1 class="heading-main heading-jumbotron">
					<small>Belajar Mandiri dengan Dukungan Penuh,</small>
					<br>
					Seperti Kelas <i>Offline</i>
				</h1>
				<p class="lead mb-4">Kursus blended learning dijamin <b class="font-weight-bolder">#PastiBisa</b>,
					dengan sesi konsultasi bersama instruktur kapan saja.</p>
				<a class="btn btn-warning btn-rounded btn-coba my-3 ">
					COBA GRATIS
				</a>
				<a class="btn btn-info btn-rounded btn-coba faa-horizontal animated" id="btn-video" data-toggle="modal"
				   data-target="#vidModal">
					<i class="fa fa-play"></i>
					Apa itu Kursus Online?
				</a>
			</div>
		</div>
	</div>
</section>
