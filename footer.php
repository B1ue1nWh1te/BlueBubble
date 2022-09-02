<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if ($this->user->hasLogin()) { ?>
	<?php if ($this->is('single')) { ?>
		<a href="<?php $this->options->adminUrl(); ?>write-<?php echo $this->is('post') ? 'post' : 'page'; ?>.php?cid=<?php echo $this->cid; ?>">
			<button id="adminbtn" class="btn btn-icon-only rounded-circle btn-primary admin-btn">
				<span class="btn-inner--icon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
			</button>
		</a>
	<?php } else { ?>
		<a href="<?php $this->options->adminUrl(); ?>">
			<button id="adminbtn" class="btn btn-icon-only rounded-circle btn-primary admin-btn">
				<span class="btn-inner--icon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
			</button>
		</a>
	<?php } ?>
<?php } ?>
</main>
<!-- Footer -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="copyright">
					<?php $this->options->footerContent(); ?>
					<?php
					$all = Typecho_Plugin::export();
					if (array_key_exists('PageViews', $all['activated']))
						PageViews_Plugin::showPageViews('总访问量：', '次');
					?>
				</div>
			</div>
		</div>
</footer>
<?php if ($this->options->Pjax) _e('</div>'); ?>
<a id="scrollup" href="#" style="display: none;">
	<button id="scrollbtn" class="btn btn-icon-only rounded-circle btn-secondary scrollup-btn">
		<span class="btn-inner--icon"><i class="fa fa-arrow-up" aria-hidden="true"></i></span>
	</button>
</a>
<!-- Core -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
<!-- Optional plugins -->
<script src="https://cdn.jsdelivr.net/npm/headroom.js@0.11.0/dist/headroom.min.js"></script>
<!-- Theme JS -->
<script src="<?php $this->options->themeUrl("assets/js/argon.min.js"); ?>"></script>
<script src="<?php $this->options->themeUrl("assets/js/bbrender.js"); ?>"></script>
<!-- scrollup -->
<script>
	$(function() {
		var scrollBottom = parseInt($("#adminbtn").css("bottom")) + parseInt($("#adminbtn").css("height")) + 25;
		$("#scrollbtn").css("bottom", scrollBottom);
		var resizeTimer;
		$(window).resize(function(e) {
			if ($("#adminbtn").length > 0) {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function() {
					scrollBottom = parseInt($("#adminbtn").css("bottom")) + parseInt($("#adminbtn").css("height")) + 25;
					$("#scrollbtn").css("bottom", scrollBottom);
				}, 250);
			}
		});
		var scrollLock = 0;
		if ($(window).scrollTop() > 500) $("#scrollup").fadeIn(400);
		$(window).scroll(function() {
			if (!scrollLock) {
				if ($(window).scrollTop() > 500) $("#scrollup").fadeIn(400);
				else $("#scrollup").fadeOut(400);
			}
		});
		$("#scrollup").click(function() {
			scrollLock = 1;
			$("#scrollup").fadeOut(400);
			$("html,body").animate({
				scrollTop: "0px"
			}, 500, function() {
				scrollLock = 0;
			});
		});
	});
</script>
<!-- Pjax -->

<script>
	function init() {
		<?php if ($this->options->prismjs and $this->options->prismLine) : ?>
			var pres = document.querySelectorAll('pre');
			var lineNumberClassName = 'line-numbers';
			pres.forEach(function(item, index) {
				item.className = item.className == '' ? lineNumberClassName : item.className + ' ' + lineNumberClassName;
			});
			Prism.highlightAll(false, null);
		<?php endif; ?>

		<?php if ($this->options->katex) : ?>
			try {
				renderMathInElement(document.body, {
					delimiters: [{
							left: "$$",
							right: "$$",
							display: true
						},
						{
							left: "$",
							right: "$",
							display: false
						}
					]
				})
			} catch {}
		<?php endif; ?>
		parseBbcode()
		parseBblink()
		<?php if ($this->options->Pjax) : ?>
			<?php $this->options->pjaxcomp() ?>
			try {
				window.onload()
			} catch {}
		<?php endif; ?>
		setTimeout(() => {
			$('.content').viewer({
				url: 'src'
			})
		}, 300)
	}

	function destroy() {
		// viewerjs
		var viewer = $('.content').data('viewer');
		if (viewer) {
			viewer.destroy()
		}
	}
	window.addEventListener("popstate", function(e) {
		setTimeout(() => {
			$('.content').viewer({
				url: 'src'
			})
		}, 300)
	}, false);
</script>
<?php if ($this->options->Pjax) : ?>
	<script src="https://cdn.jsdelivr.net/npm/jquery-pjax@2.0.1/jquery.pjax.js"></script>
	<script src="<?php $this->options->themeUrl("assets/js/progress.js"); ?>"></script>
	<script>
		var pgid = 0
		$(document).pjax('a[href^="<?php Helper::options()->siteUrl() ?>"]:not(a[target="_blank"], a[no-pjax], a[href^="<?php Helper::options()->siteUrl() ?>/admin"])', {
			container: '#pjax-container',
			fragment: '#pjax-container',
			timeout: 8000
		}).on('pjax:send', function() {
			pgid = start_progress()
			$(".black-cover").fadeIn(400)
			$('html,body').animate({
				scrollTop: $('html').offset().top
			}, 500)

			destroy()
		}).on('pjax:complete', function() {
			$(".black-cover").fadeOut(400)
			stop_progress(pgid)
			init()

		})
		$("#search").submit(function() {
			var att = $(this).serializeArray()
			for (var i in att) {
				if (att[i].name == "s") {
					$.pjax({
						url: <?php if ($this->options->rewrite) : ?> "<?php $this->options->siteUrl(); ?>search/" + att[i].value + "/"
					<?php else : ?> "<?php $this->options->siteUrl(); ?>index.php/search/" + att[i].value + "/"
					<?php endif; ?>,
					container: '#pjax-container',
					fragment: '#pjax-container',
					timeout: 8000
					})
				}
			}
			return false
		})
	</script>
	<div class="black-cover" style="display: none;"></div>
<?php endif; ?>
<!-- KaTeX JS -->
<?php if ($this->options->katex) : ?>
	<script src="https://cdn.jsdelivr.net/npm/katex@0.11.1/dist/katex.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/katex@0.11.1/dist/contrib/auto-render.min.js"></script>
<?php endif; ?>
<!-- Prism JS -->
<?php if ($this->options->prismjs) : ?>
	<script src="https://cdn.jsdelivr.net/npm/prismjs@1.20.0/components/prism-core.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/prismjs@1.20.0/plugins/autoloader/prism-autoloader.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/prismjs@1.20.0/plugins/toolbar/prism-toolbar.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/prismjs@1.20.0/plugins/show-language/prism-show-language.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/prismjs@1.20.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
	<?php if ($this->options->prismLine) : ?>
		<script src="https://cdn.jsdelivr.net/npm/prismjs@1.20.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
	<?php endif; ?>
<?php endif; ?>
<!-- Alert -->
<div id="modal-notification" class="modal fade show" id="modal-notification" style="z-index: 102;display: none;">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="msgMain" class="modal-title" id="mySmallModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#modal-notification').hide('normal');">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div id="msgDetail" class="modal-body"></div>
		</div>
	</div>
</div>
<script>
	function alert(main, detail) {
		$("#msgMain").html(main)
		if (detail) $("#msgDetail").html(detail)
		else $("#msgDetail").html("")
		$("#modal-notification").show("normal");
	}
	init()
</script>
<!-- Typecho footer -->
<?php $this->footer(); ?>
</body>

</html>