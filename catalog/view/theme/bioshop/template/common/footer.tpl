		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-xs-4 social-links">
						<p>Мы в социальных сетях:</p>

						<div class="social">
							<ul>
								<li><a href="https://twitter.com/"></a></li>
								<li><a href="https://www.facebook.com/?ref=logo"></a></li>
								<li><a href="https://www.linkedin.com/"></a></li>
								<li><a href="http://tumblr.com/"></a></li>
							</ul>
						</div>
					</div>
                                        <?php if ($informations) { ?>
                                        <div class="col-lg-2 col-xs-2 footer-menu">
                                             <ul>
                                                <li><a href="<?php echo $informations['Доставка']['href']; ?>"><?php echo $informations['Доставка']['title']; ?></a></li>
                                                <li><a href="<?php echo $informations['Оплата']['href']; ?>"><?php echo $informations['Оплата']['title']; ?></a></li>
                                                <li><a href="<?php echo $informations['Блог']['href']; ?>"><?php echo $informations['Блог']['title']; ?></a></li>
                                                <li><a href="<?php echo $informations['Вакансии']['href']; ?>"><?php echo $informations['Вакансии']['title']; ?></a></li>
                                              </ul>
                                        </div>
                                        <div class="col-lg-3 col-xs-3 footer-menu-2">
                                            <ul> 
                                                <li><a href="<?php echo $informations['Вопрос ответ']['href']; ?>"><?php echo $informations['Вопрос ответ']['title']; ?></a></li>
                                                <li><a href="<?php echo $informations['Контакты']['href']; ?>"><?php echo $informations['Контакты']['title']; ?></a></li>  
                                                <li><a href="<?php echo $informations['Сотрудничество']['href']; ?>"><?php echo $informations['Сотрудничество']['title']; ?></a></li>  
                                                <li><a href="<?php echo $informations['О компании']['href']; ?>"><?php echo $informations['О компании']['title']; ?></a></li>  
                                            </ul>            
                                         </div> 
                                         <?php } ?>
                                         
                

					<div class="col-lg-3 col-xs-3 subscribe">
						<p>Подписка на новости</p>
						<div class="uncknown"></div>
						<a href="<?php echo $newsletter; ?>">Подпишитесь
                                                    <a href="<?php echo $informations['Соглашение о конфиденциальности']['href']; ?>"><?php echo $informations['Соглашение о конфиденциальности']['title']; ?></a>
					</div>
				</div>
			</div>
		</footer>
		<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
	</body>
</html>