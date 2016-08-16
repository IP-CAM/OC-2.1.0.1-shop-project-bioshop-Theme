		  <div class="container">	
                       <div class="seo-text">
		         <b>Необычный SEO - текст</b>
                             <p>
				Проснувшись однажды утром после беспокойного сна, Грегор Замза обнаружил, что он у себя в постели превратился в страшное насекомое. Лежа на панцирнотвердой спине, он видел, стоило ему приподнять голову, свой коричневый, выпуклый, разделенный дугообразными чешуйками живот, на верхушке которого еле держалось готовое вот-вот окончательно сползти одеяло. Его многочисленные, убого тонкие по сравнению с остальным телом ножки беспомощно копошились у него перед глазами. «Что со мной случилось?» – подумал он. Это не было сном. Его комната, настоящая, разве что слишком маленькая, но обычная комната, мирно покоилась в своих четырех хорошо знакомых стенах. Над столом, где были разложены распакованные образцы сукон – Замза был коммивояжером, – висел портрет, который он недавно вырезал из иллюстрированного журнала и вставил в красивую золоченую рамку. На портрете была изображена дама в меховой шляпе и боа, она сидела очень прямо и протягивала зрителю тяжелую меховую муфту, в которой целиком исчезала ее рука. Затем взгляд Грегора устремился в окно, и пасмурная погода – слышно было, как по жести подоконника стучат капли дождя – привела его и вовсе в грустное настроение. «Хорошо бы еще немного поспать и забыть всю эту чепуху», – подумал он, но это было совершенно неосуществимо, он привык спать на правом боку, а в теперешнем своем
			     </p>
		       </div>
                   </div>
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