<section>
	<p>Some people can stop or reduce their drinking by themselves, while others might need some additional support. See which option below suits you best.</p>
</section>
<section>
	<div class="support-info">
		<?php foreach ($services as $service): ?>
			<div class="contact-group">
				<h4><?php echo htmlentities($service['name']); ?></h4>
				<ul>
					<?php if (!empty($service['contact_numbers'])): ?>
						<li class="service-contact-numbers">
							<i class="icn green-phone-sm"></i>
							<strong>Phone</strong>
							<span><?php echo nl2br(htmlentities($service['contact_numbers'])); ?></span>
						</li>
					<?php endif; ?>
					<?php if (!empty($service['address'])): ?>
						<li class="service-address">
							<i class="icn green-pins"></i>
							<strong>Address</strong>
							<span><?php echo nl2br(htmlentities($service['address'])); ?></span>
						</li>
					<?php endif; ?>
					<?php if (!empty($service['opening_hours'])): ?>
						<li class="service-opening-hours">
							<i class="icn green-clock"></i>
							<strong>Opening hours</strong>
							<span><?php echo nl2br(htmlentities($service['opening_hours'])); ?></span>
						</li>
					<?php endif; ?>
					<?php if (!empty($service['fees'])): ?>
						<li class="service-fees">
							<i class="icn green-fees"></i>
							<strong>Fees</strong>
							<span><?php echo htmlentities($service['fees']);?></span>
						</li>
					<?php endif; ?>
					<?php if (!empty($service['website'])): ?>
						<li class="service-website">
							<i class="icn green-globe"></i>
							<strong>Website</strong>
							<span>
								<?php $websites = array(); ?>
								<?php foreach (explode(',', $service['website']) as $url): ?>
									<?php $url = htmlentities(trim($url)); ?>
									<?php $websites[] = '<a href="' . $url . '">' . $url . '</a>'; ?>
								<?php endforeach; ?>
								<?php echo implode('<br>', $websites); ?>
							</span>
						</li>
					<?php endif; ?>
					<?php if (!empty($service['additional_info'])): ?>
						<li class="service-additional-info">
							<i class="icn green-additional"></i>
							<strong>Additional info</strong>
							<span><?php echo nl2br(htmlentities($service['additional_info'])); ?></span>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		<?php endforeach; ?>
	</div>
</section>
