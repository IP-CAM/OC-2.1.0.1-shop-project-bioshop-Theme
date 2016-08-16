<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/bioshop/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>
</head>
   <body> 
      <header class="header container">
	     <div class="row top-header">
		 <div class="col-lg-3 col-lg-offset-9 col-xs-3 col-xs-offset-9 top-navigation">
		      <ul>
                          <?php if ($logged) { ?>
                          <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
		          <?php } else { ?>
                          <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a>&nbsp;/&nbsp;<a href="<?php echo $register; ?>"><?php echo $text_register; ?></a></li>
                           <?php } ?>
                      </ul>
		      </div>
		      </div>
		      <div class="row main-header">
			<!-- LOGO CONTAINER -->
			<div class="col-lg-3 col-xs-3">
                           <div id="logo">
                           <?php if ($logo) { ?>
                           <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
                           <?php } else { ?>
                           <h1>
                               <a href="<?php echo $home; ?>">Naturel  boutique
                                  <span><?php echo $name; ?></span>
                               </a>
                           </h1>
                           <?php } ?>
                         </div>
                         </div>
				<!-- SEARCH, CALLBACK, BASKET -->
                        <div class="col-lg-7 col-lg-offset-2 col-xs-7 col-xs-offset-2 header-content">
                            <div class="row">
				<div class="col-lg-5 col-xs-5 wrapper-search">
                                    <!--<form>-->
                                        <div class="col-sm-5"><?php echo $search; ?></div>
					<!--<input type="submit" value="">-->
                                    <!--</form>-->
				</div>
				<div class="col-lg-5 col-xs-5 call-back">
                                    <p>
					<span><?php echo $telephone; ?></span>
					<a href="<?php echo $contact; ?>">мы перезвоним</a>
                                    </p>
				</div>
				<div class="col-lg-2 col-xs-2 basket">
                                    <!--<a href="#">Покупки
					<span></span>
                                    </a>-->
                                    <div class="col-sm-3"><?php echo $cart; ?></div>
				</div>
                            </div>
			</div>
			</div>
			<!-- MAIN NAVIGATION -->
                        <?php if ($categories) { ?>
			<div class="row header-navigation">
                            <div class="col-lg-12">
				<nav class="navbar navbar-default">
                                    <div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
                                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
                                            </button>
					</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
                                         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                            <ul class="nav navbar-nav">
                                            <?php foreach ($categories as $category) { ?>
                                            <?php if ($category['children']) { ?>
                                            <li class="dropdown"><a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?></a>
                                                <div class="dropdown-menu">
                                                    <div class="dropdown-inner">
                                                        <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
                                                        <ul class="list-unstyled">
                                                            <?php foreach ($children as $child) { ?>
                                                                 <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                        <?php } ?>
                                                    </div>
                                                   <a href="<?php echo $category['href']; ?>" class="see-all"><?php echo $text_all; ?> <?php echo $category['name']; ?></a> </div>
                                            </li>
                                            <?php } else { ?>
                                            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                                            <?php } ?>
                                           <?php } ?>
                                           </ul>
					</div>
                                    </div>
				</nav>
                            </div>
			</div>
                       <?php } ?> 
                      </header>
                      <!--<div class="container break-stripe"></div>-->
                