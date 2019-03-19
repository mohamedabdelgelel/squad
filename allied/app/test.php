<!DOCTYPE html>

<html>

<head>

    <title>Squad 101</title>

    <!-- for-mobile-apps -->

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="keywords"
          content="Erp, Allied Consulting , Erp Courses , Sap , IOT , Gis, Consulting, Support, Training,Outsourcing,Development,Integration,Application,SAP Consultancy , Technical Support"/>


    <link href="/css/bootstrap.css" rel="stylesheet" id="">

    <link rel="shortcut icon" type="image/png" href="/images/newlogo.png"/>


    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>

    <link rel="stylesheet" href="/css/styleSlider2.css">

    <link rel="stylesheet" href="/css/squad2.css">

    <link rel="stylesheet" href="/css/popUp2.css">

    <link rel="stylesheet" href="/css/form2.css">

    <link rel="stylesheet" href="/css/VE2.css">


    <link href="/css/style2.css" rel="stylesheet" type="text/css" media="all"/>

    <!-- js -->

    <script type="text/javascript" src="/js/jquery-2.1.4.min.js"></script>

    <!-- //js -->

    <script type="text/javascript" src="/js/bootstrap-3.1.1.min.js"></script>


    <!-- Spectrum -->


    <!-- start-smoth-scrolling -->

    <script type="text/javascript" src="js/move-top.js"></script>

    <script type="text/javascript" src="js/easing.js"></script>

    <!--animate-->

    <link href="/css/animate2.css" rel="stylesheet" type="text/css" media="all">

    <script src="/js/wow.min.js"></script>

    <script>

        new WOW().init();

    </script>

    <!--//end-animate-->

    <link href="/css/profile2.css" rel="stylesheet" id="bootstrap-css">


    <script src="/js/bootstrap-3.1.1.min.js"></script>

    <script src="/js/jquery-2.1.4.min.js"></script>

    <!------ Include the above in your HEAD tag ---------->

</head>


<body>

<div class="header">

    <div class="container">

        <div class="header-left grid">

            <div class="grid__item color-1 wow zoomIn" data-wow-duration="1s" data-wow-delay="0.5s">

            </div>


        </div>

        <div class="clearfix"></div>

    </div>

</div>

<div id="myimage" class="banner">

    <div class="ban-top ">

        <div class="container">

            <div class="ban-top-con">

                <div class="top_nav_left">

                    <nav class="navbar navbar-default">

                        <div class="container-fluid">

                            <!-- Brand and toggle get grouped for better mobile display -->

                            <div class="navbar-header">

                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">

                                    <span class="sr-only">Toggle navigation</span>

                                    <span class="icon-bar"></span>

                                    <span class="icon-bar"></span>

                                    <span class="icon-bar"></span>

                                </button>

                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->

                            @include('layouts.nav')

                        </div>

                    </nav>

                </div>

                <div class="clearfix"></div>

            </div>

        </div>

    </div>


</div>


<div class="info col-lg-12 col-sm-12">


    <div class="well">

        <div class="col-sm-4" id='cssmenu'>

            <ul>


                <li><a href='/viewMeals'>View All Recipe</a></li>
                <li><a href='/viewType/1'>view Breakfast Recipe</a></li>
                <li><a href='/viewType/2'>view AM Snacks Recipe</a></li>
                <li><a href='/viewType/3'>view Lunch Recipe</a></li>
                <li><a href='/viewType/4'>view PM Snacks Recipe</a></li>
                <li><a href='/viewType/5'>view Dinner Recipe</a></li>
                <li><a href='/assignMeal'>Assign Recipe</a></li>
                <li><a href='/assingAllMeals'>Search Recipe </a></li>
                <li><a href='/viewReport'>Report Recipe</a></li>
                <li><a href='/createMeals'>Create Recipe</a></li>
                <li><a href='/viewIngredient'>View Ingredients</a></li>
                <li><a href='/createIngredient'>Create Ingredient</a></li>
                <li><a href='/createUnit'>Create Unit</a></li>
                <li><a href='/viewUnit'>View Units</a></li>
                <li><a href='/createClasses'>Create Category</a></li>
                <li><a href='/viewClasses'>View Category</a></li>


            </ul>

        </div>


        <div class="tab-content col-sm-9">

            <div class="tab-pane  fade in active" id="tab1">

                <form method="post" action="/trackmeal">

                    {{csrf_field()}}        <!--  General -->


                    <label class="col-lg-3 control-label"> From:</label>

                    <div class="col-lg-8">

                        <input class="form-control" type="date" name="from">

                    </div>
                    <label class="col-lg-3 control-label"> to</label>

                    <div class="col-lg-8">

                        <input class="form-control" type="date" name="to">

                    </div>

                    <input type="submit" class="btn btn-primary" value="select">

                </form>

                <!--start table-->


                <div class="table_content">

                    <div class="container">


                        <div class="row ">


                        </div>


                        <div class="row">

                            <div id="table">

                                <div class="col-md-11">

                                    <!--pic10-->

                                    <table id="dtVerticalScrollExample"
                                           class="table table-striped table-bordered table-sm" cellspacing="0"
                                           width="100%">

                                        <thead>

                                        <tr>

                                            <th class="th-sm">Type

                                                <i class="fa fa-sort float-right" aria-hidden="true"></i>

                                            </th>

                                            <th class="th-sm emp">Meal

                                                <i class="fa fa-sort float-right" aria-hidden="true"></i>

                                            </th>
                                            <th class="th-sm emp">Date

                                                <i class="fa fa-sort float-right" aria-hidden="true"></i>

                                            </th>

                                            <th class="th-sm emp">Total Calories

                                                <i class="fa fa-sort float-right" aria-hidden="true"></i>

                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>

                                        @if(isset($mealbs))

                                        @php($calories=0)


                                        <tr>

                                            <td>Breakfast</td>

                                            <td></td>
                                            <td></td>

                                            @foreach($mealbs as $meal)

                                            @foreach($meal->meal->recipes as $recipe)


                                            @foreach($recipe->recipe->ingredients as $ingredient)

                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)

                                            @endforeach

                                            @endforeach


                                            @endforeach

                                            <td>{{$calories}}</td>


                                        </tr>

                                        @foreach($mealbs as $meal)

                                        @php($calories=0)


                                        <tr>


                                            <td></td>


                                            <td> {{$meal->meal->name}}</td>

                                            <td>{{$meal->date}}</td>


                                            @foreach($meal->recipes as $recipe)

                                            @foreach($recipe->recipe->ingredients as $ingredient)

                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)
                                            @endforeach

                                            @endforeach
                                            <td>{{$calories}}</td>


                                        </tr>

                                        @endforeach

                                        @endif

                                        @if(isset($mealams))

                                        @php($calories=0)

                                        <tr>

                                            <td>Am Snack</td>


                                            <td></td>

                                            @foreach($mealams as $meal)


                                            @foreach($meal->meal->recipes as $recipe)


                                            @foreach($recipe->recipe->ingredients as $ingredient)
                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)

                                            @endforeach


                                            @endforeach

                                            @endforeach

                                            <td>{{$calories}}</td>

                                        </tr>

                                        @foreach($mealams as $m)


                                        @php($calories=0)


                                        <tr>


                                            <td></td>


                                            <td> {{$meal->meal->name}}</td>

                                            <td>{{$meal->date}}</td>


                                            @foreach($meal->recipes as $recipe)

                                            @foreach($recipe->recipe->ingredients as $ingredient)

                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)
                                            @endforeach

                                            @endforeach
                                            <td>{{$calories}}</td>


                                        </tr>

                                        @endforeach

                                        @endif

                                        @if(isset($smealls))

                                        @php($calories=0)

                                        <tr>

                                            <td>Lunch</td>


                                            <td></td>

                                            @foreach($smealls as $meal)


                                            @foreach($meal->meal->recipes as $recipe)


                                            @foreach($recipe->recipe->ingredients as $ingredient)

                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)

                                            @endforeach

                                            @endforeach


                                            @endforeach

                                            <td>{{$calories}}</td>

                                        </tr>

                                        @foreach($smealls as $m)

                                        @php($calories=0)


                                        <tr>


                                            <td></td>


                                            <td> {{$meal->meal->name}}</td>

                                            <td>{{$meal->date}}</td>


                                            @foreach($meal->recipes as $recipe)

                                            @foreach($recipe->recipe->ingredients as $ingredient)

                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)
                                            @endforeach

                                            @endforeach
                                            <td>{{$calories}}</td>


                                        </tr>

                                        @endforeach

                                        @endif

                                        @if(isset($smealpms))

                                        @php($calories=0)

                                        <tr>

                                            <td>Pm Snack</td>


                                            <td></td>

                                            @foreach($smealpms as $meal)


                                            @foreach($meal->meal->recipes as $recipe)


                                            @foreach($recipe->recipe->ingredients as $ingredient)
                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)

                                            @endforeach

                                            @endforeach


                                            @endforeach

                                            <td>{{$calories}}</td>

                                        </tr>

                                        @foreach($smealpms as $m)


                                        @php($calories=0)


                                        <tr>


                                            <td></td>


                                            <td> {{$meal->meal->name}}</td>

                                            <td>{{$meal->date}}</td>


                                            @foreach($meal->recipes as $recipe)

                                            @foreach($recipe->recipe->ingredients as $ingredient)

                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)
                                            @endforeach

                                            @endforeach
                                            <td>{{$calories}}</td>


                                        </tr>

                                        @endforeach

                                        @endif

                                        @if(isset($mealds))

                                        @php($calories=0)

                                        <tr>

                                            <td>Dinner</td>


                                            <td></td>

                                            @foreach($mealds as $meal)


                                            @foreach($meal->meal->recipes as $recipe)


                                            @foreach($recipe->recipe->ingredients as $ingredient)

                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)

                                            @endforeach

                                            @endforeach


                                            @endforeach

                                            <td>{{$calories}}</td>

                                        </tr>

                                        @foreach($mealds as $m)


                                        @php($calories=0)


                                        <tr>


                                            <td></td>


                                            <td> {{$meal->meal->name}}</td>

                                            <td>{{$meal->date}}</td>


                                            @foreach($meal->recipes as $recipe)

                                            @foreach($recipe->recipe->ingredients as $ingredient)

                                            @php($calories+=$ingredient->quantity * $ingredient->ingredients->calories)
                                            @endforeach

                                            @endforeach
                                            <td>{{$calories}}</td>


                                        </tr>

                                        @endforeach

                                        @endif


                                        </tbody>

                                    </table>


                                </div>

                            </div>


                        </div>

                    </div>

                </div>


                <!--end table-->


            </div>


        </div>

    </div>


</div>


</body>


<script src="js/profile.js"></script>


</html>