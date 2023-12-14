<main>
  <div class="inner-main">
    <div class="content-block-lv2">
        <h1 class="hstyle-primary">管理者画面</h1>
        <div class="card">
            <div class="wrap-tab">
                <a class="tab" href="<?= base_url() ?>management-selling-schedule">本日発送予定分</a>
                <a class="tab active" href="<?= base_url() ?>management-enquiry">お問い合わせ</a>
                <a class="tab" href="<?= base_url() ?>management-schedule">納品予定連絡</a>
            </div>
            <div class="enquiry-lines" style="display: inline-flex; margin-bottom: 5px">
                <div style="padding: 5px 10px">
                    <span>全<?= count($enquiries) ?>件</span>
                </div>
            </div>

            <div class="content-block-lv3">

                <table class="enquiry-table">
                    <tbody>
                        <?php foreach($enquiries as $enquiry) {?>
                        <tr id="enquiry-row-<?= $enquiry['id'] ?>" class="parent-enquiry">
                            <td class="custom-table-row custom-w-60 text-center"><b>#<?= str_pad($enquiry['id'], 5, '0', STR_PAD_LEFT) ?></a></b></td>
                            <td class="custom-table-row custom-w-120 text-center"><b>会員: <?= $enquiry['member_id'] ?></a></b></td>
                            <td class="custom-table-row"><b><a href="#" class="enquiry" id="enquiry-<?= $enquiry['id'] ?>" style="width: 100%;"><div><?= $enquiry['subject'] ?></div></a></b></td>
                            <td class="custom-table-row custom-w-150 text-center"><b><?= $enquiry['updated_at'] ?></b></td>
                            <td class="custom-table-row custom-w-60 text-center"><b><?= $enquiry['is_completed']?'終了':'未終了' ?><input id="enquiry-ajax-<?= $enquiry['id'] ?>" style="display:none;" value="0"></b></td>
                        </tr>
                        <tr id="enquiry-content-<?= $enquiry['id'] ?>"><td colspan="<?= $this->session->userdata('isadmin')?'5':'4'?>" class="custom-table-row main-enquiry-content" style="display: none;"><?= $enquiry['content'] ?><small><?= '['.$enquiry['created_at'].']' ?></small></td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>

</main>

<script>

    $(document).on('click', '.enquiry', function() {
        var enquiry_id = $(this).attr('id').split('-')[1];
        
        if($('#enquiry-ajax-' + enquiry_id).val() == 1) {
            $('#enquiry-row-' + enquiry_id).toggleClass('enquiry-row-selected');
            $('#enquiry-content-' + enquiry_id + ' td').toggle();
            $('.enqury-reply-' + enquiry_id).toggle();
            return;
        }
        
        $.post('<?= base_url() ?>enquiry/open-child', {
            _method: 'POST',
            enquiry_id: enquiry_id
        })
        .done(function(response) {
            try {
                $('#enquiry-row-' + enquiry_id).css('background-color', '#8ee4ff');

                $('#enquiry-content-' + enquiry_id + ' td').show();

                var replies = response.replies;
                
                var html = '';

                replies.map((reply) => {
                    html += `<tr class="enqury-reply-${enquiry_id} admin-enquiry-${reply.type==0?'member':'admin'}-tr"><td style="border:none !important;" class="" colspan="<?= $this->session->userdata('isadmin')?'5':'4'?>"><p class="admin-enquiry-${reply.type==0?'member':'admin'}-p">${reply.content}<small>${(reply.type==0?'<?= $this->session->userdata('name') ?> 様 [':'管理者 [')+reply.created_at+']'}</small><p></td></tr>`;
                });

                html += `<tr class="enquiry-content-<?= $enquiry['id'] ?>"><td colspan="<?= $this->session->userdata('isadmin')?'5':'4'?>" class="custom-table-row enqury-reply-${enquiry_id}"><textarea id="reply-${enquiry_id}"></textarea><a class="btn submit-enquiry" id="submit-${enquiry_id}">送信する</a><a class="btn close-enquiry" id="close-${enquiry_id}"> 終 了 </a></td></tr>`;

                $('#enquiry-content-' + enquiry_id).after(html);

                $('#enquiry-ajax-' + enquiry_id).val(1);
            } catch (error) {
                console.error("Error parsing response:", error);
            }
        })
        .fail(function(xhr, textStatus, errorThrown) {
            console.error("AJAX request failed:", textStatus, errorThrown);
        });
    });

    $(document).on('click', 'a.btn.submit-enquiry', function() {
        var enquiry_id = $(this).attr('id').split('-')[1];
        var content = $('#reply-'+enquiry_id).val();

        if(content == '') return;

        $.post('<?=base_url()?>enquiry/reply', {
            _method: 'POST',
            parent_id: enquiry_id,
            content: content
        })
        .done(function(response){
            if(response.result) {
                window.location.reload();
            }
        })
        .fail(function(xhr, textStatus, errorThrown) {
            console.error("AJAX request failed:", textStatus, errorThrown);
        });
    });

    $(document).on('click', 'a.btn.close-enquiry', function() {
        var enquiry_id = $(this).attr('id').split('-')[1];

        $.post('<?=base_url()?>enquiry/close', {
            _method: 'POST',
            enquiry_id: enquiry_id,
            content: $('#close-'+enquiry_id).val()
        })
        .done(function(response){
            if(response.result) {
                window.location.reload();
            }
        })
        .fail(function(xhr, textStatus, errorThrown) {
            console.error("AJAX request failed:", textStatus, errorThrown);
        });
    });

</script>