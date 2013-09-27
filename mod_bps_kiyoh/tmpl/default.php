<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
$fStarValue = modBPSKiyohHelper::round_to_half(($aXmlInfo['total_score']/$iBest)*5);
?>
<script>
window.addEvent('domready', function(){
	$$('.extended').each(function(el) {
		var acc = new Fx.Accordion(el.getElements('.first'),el.getElements('.second'),{
			display: -1,
			alwaysHide: true,
			onActive: function(toggler) { toggler.addClass('active'); },
			onBackground: function(toggler) { toggler.removeClass('active'); }
		});
	});


});



</script>
<div class="kiyohRating" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
    <img itemprop="photo" src="<?php echo $sLogoUrl; ?>" alt="" /><br/>
    Beoordeling <span itemprop="itemreviewed"><?php echo $aXmlInfo['naam']; ?></span> <a class="kiyohLink" href="<?php echo $aXmlInfo['kiyohLink']; ?>" target="_blank" title="Schrijf ook een recensie voor <?php echo $aXmlInfo['naam']; ?>">Kiyoh</a><br/>

	<div class="kiyoh-rating">
		<div class="rstar rstar-<? echo number_format($fStarValue,1,'',''); ?>"></div>
		<span class="kiyoh-ratingscore" itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
		  <span itemprop="average"><?php echo $aXmlInfo['total_score']; ?></span>
		  / <span itemprop="best"><?php echo $iBest; ?></span>
		</span>
	</div>
    op basis van <span itemprop="votes"><?php echo $aXmlInfo['total_reviews']; ?></span> beoordelingen.<br/>
	<?php if ($params->get('showReviews',true)) : ?>
		<span itemprop="count"><?php echo $aXmlInfo['reviewCount']; ?></span> gebruikersrecensies.<br/>
 <?php// print_r_pre($aXmlInfo);		?>
		<?php 
		$shown = 0;
		foreach ($aXmlInfo['aReviews'] as $aReview) :
			if ($shown >= $params->get('nrReviews',2)) break;
		?>
			<div class="kiyoh-review">
			  <div itemscope itemtype="http://data-vocabulary.org/Review">
				
				<em>Beoordeling <span itemprop="itemreviewed"><?php echo $aXmlInfo['naam']; ?></span></em><br/>
				door: <span itemprop="reviewer"><?php echo $aReview['naam']; ?></span> op
				<time itemprop="dtreviewed" datetime="<?php echo $aReview['dateRaw']; ?>"><?php echo $aReview['date']; ?></time>.
				<?php if ($params->get('showDescription',true)) :
						//init
						$sPosSpan = '<span class="pos">';
						$sNegSpan = '<span class="neg">';
						$sCloseSpan = '</span>';
						$sDots = '...';
						$sTotalstring = $sPosSpan.$aReview['positive'].$sCloseSpan.' '.$sNegSpan.$aReview['negative'].$sCloseSpan;
						$iTotalLength = strlen($aReview['positive'].$aReview['negative']);
						$iPosLength = strlen($aReview['positive']);
						$iNegLength = strlen($aReview['negative']);
						$iMaxlength = (int)$params->get('maxLength',200);
						$sFirststring = $sTotalstring; 
						$sSecondstring = '';
						$sClass = ''; 
						//past het?
						if ($iTotalLength > $iMaxlength) {
							$sClass = 'extended';
							if ($iPosLength <= $iMaxlength) { //deel1 past wel, compleet erbij
								$sFirststring = $sPosSpan.$aReview['positive'].$sCloseSpan;
								//aanvullen met deel2
								$sFirststring .= ' '.$sNegSpan.substr($aReview['negative'],0,($iMaxlength-$iPosLength)).$sDots.$sCloseSpan;
								$sSecondstring = $sNegSpan.substr($aReview['negative'],($iMaxlength-$iPosLength)).$sCloseSpan;
							} else { //deel1 past al niet
								$sFirststring = $sPosSpan.substr($aReview['positive'],0,$iMaxlength).$sDots.$sCloseSpan;
								$sSecondstring = $sPosSpan.substr($aReview['positive'],$iMaxlength).$sCloseSpan.' '.$sNegSpan.$aReview['negative'].$sCloseSpan;
							}


						}
				?>
					<div class="kiyoh-description <?php echo $sClass; ?>" itemprop="description">
						<div class="first"><?php echo $sFirststring; ?></div>
						<div class="second"><?php echo $sSecondstring; ?></div>
					</div>
				<?php endif; ?>
				<span class="kiyoh-review-rating">Beoordeling: <span class="kiyoh-review-ratingscore" itemprop="rating"><?php echo $aReview['total_score']; ?></span></span>
			  </div>
			</div>
		<?php 
			$shown++;
			endforeach; ?>
	<?php endif; ?>
    <a class="kiyohLink" href="<?php echo $aXmlInfo['kiyohLink']; ?>" target="_blank" title="Schrijf ook een recensie voor <?php echo $aXmlInfo['naam']; ?>">
		Schrijf een recensie voor <?php echo $aXmlInfo['naam']; ?>
		<img src="/modules/mod_bix_printshop_kiyoh/assets/logo_kiyoh.png" alt="" />
	</a>
 </div> 

