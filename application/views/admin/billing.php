<main>
    <div class="inner-main">
        <div class="content-block-lv2">
            <h1 class="hstyle-primary">管理者画面</h1>

            <div class="card">
                <div class="content-block-lv1">
                    <div class="wrap-tab">
                    <a class="tab" href="<?= base_url() ?>management-selling-schedule">本日発送予定分</a>
                    <a class="tab" href="<?= base_url() ?>management-enquiry">お問い合わせ</a>
                    <a class="tab" href="<?= base_url() ?>management-schedule">納品予定連絡</a>
                    <a class="tab active" href="<?= base_url() ?>management-schedule">取引履歴</a>
                    </div>
                </div>
                <div class="content-block-lv2">
                    <table class="enquiry-table">
                        <thead>
                            <tr>
                                <th class="s-schedule-th">会員番号</th>
                                <th class="s-schedule-th">会員名前</th>
                                <th class="s-schedule-th">料金</th>
                                <th class="s-schedule-th">取引日</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($billings as $billing) {
                            
                            $paid_date = new DateTime($billing['created_at']);
                            $paid_date = $paid_date->format("Y年m月d日");
                            ?>
                            <tr>
                                <td class="text-center"><?= $billing['member_id'] ?></td>
                                <td class="text-center"><?= $billing['name'] ?></td>
                                <td class="text-right">
                                    <span class="custom-padding-20">
                                        <?= $billing['fee_type'].': '.$billing['fee_amount'] ?>
                                    </span>
                                </td>
                                <td class="text-center"><?= $paid_date ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>

</script>