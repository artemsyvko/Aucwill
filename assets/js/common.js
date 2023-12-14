/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	$().on("click", ".searchList", function(){

	});

	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
function CopyToClipboard(container_id) {
	$('.code-copy-message').hide();
	if (window.getSelection) {
		if (window.getSelection().empty) { // Chrome
			window.getSelection().empty();
		} else if (window.getSelection().removeAllRanges) { // Firefox
			window.getSelection().removeAllRanges();
		}
	} else if (document.selection) { // IE?
		document.selection.empty();
	}

	if (document.selection) {
		var range = document.body.createTextRange();
		range.moveToElementText(document.getElementById(container_id));
		range.select().createTextRange();
		document.execCommand("copy");
	} else if (window.getSelection) {
		var range = document.createRange();
		range.selectNode(document.getElementById(container_id));
		window.getSelection().addRange(range);
		document.execCommand("copy");
	}
	if (window.getSelection) {
		if (window.getSelection().empty) { // Chrome
			window.getSelection().empty();
		} else if (window.getSelection().removeAllRanges) { // Firefox
			window.getSelection().removeAllRanges();
		}
	} else if (document.selection) { // IE?
		document.selection.empty();
	}
	$('.code-copy-message').show();
	$('.code-copy-message').fadeToggle(1000);
}

// ハンバーガーメニュー動作

$(function () {
  $('.wrap-hm').on('click', function () {
    if (!$(this).hasClass('clicked')) {
      $(this).toggleClass('clicked');
      change_class();
    } else {
      $(this).toggleClass('clicked');
      change_class();
    }
  });
  function change_class() {
    $('#hm').toggleClass('open');
    $('body').toggleClass('scroll-prevent');
    $('#hm-icon').toggleClass('close');
    $('nav.drawer-nav').toggleClass('open');
    $('.drawer-overlay').toggleClass('show');
  }
});

//(?)クリック時の動作
$(function () {
  $('.question').on('click', function () {
    $(this).siblings('.toggle-el').fadeToggle();
  });
  $('.btn-question').on('click', function () {
    $(this).parent().next('.toggle-el').fadeToggle();
  });
});


// 「ファイルを追加する」
$(function () {
  $('.file-add').click(function (event) {
    $(this).prev('.parent-file-add').append('<input type="file" name="files[]">');
  });
});

//納品予定一覧 メモの横幅いっぱいに
$(function () {
  var w = $(window).width();
  var x = 767;
  if (w <= x) {
    if ($('.list-subInfo').length) {
      let wd = $('.table-row').get(0).scrollWidth;
      $('.list-subInfo').css('width', wd - 70);
    }
  }
});

//「原価・メモを編集」クリック
$(function () {
  $('input.switch-memo').change(function () {
    if ($(this).prop('checked')) {
      $('.memo').show(200);
    } else {
      $('.memo').hide(200);
    }
  });
});

//発送チェック時の動作
$(function () {
  $("input[type='checkbox']").on('change', function () {
    if ($('input.check-send:checked').length > 0) {
      $('.bottom-fixnav').addClass('active');
    } else {
      $('.bottom-fixnav').removeClass('active');
    }
  });
});

//「絞り込み検索」クリック時の動作
$(function () {
  $('h2.icon-filter').on('click', function () {
    $(this).siblings('.wrap-filter').fadeToggle();
    $(this).toggleClass('close');
  });
});

//お問い合わせフォーム modal
$(function () {
  $('.contactForm').click((e) => {
    $('#contact-prefix').val($(e.target).data('prefix'))
    $('#contact-send').prop('disabled', false)
  })
  $('.contactForm').modaal({
    overlay_opacity: 0.5,
    animation_speed: 100,
  });
});

$('#contact-send').click(function () {
  $('#contact-send').prop('disabled', true)
  $('#contact-send').text('送信中')
  $.post('/contact', {
    message:$('#contact-message').val(),
    prefix: $('#contact-prefix').val(),
  }).then(function () {
    alert('お問い合わせを受け付けました');
    $('.contactForm').modaal('close')
  })
})

