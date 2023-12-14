<main>
  <div id="app" class="inner-main">
    <div class="content-block-lv2">
      <h1 class="hstyle-primary">会員リスト</h1>
      <div class="card">
      <div class="content-block-lv3">
        <div style="width: 100%; text-align: right; padding-top: 15px; padding-bottom: 15px;"><a href="<?=base_url()?>cuser" class="member-register-btn">新規会員登録</a></div>
        <table class="enquiry-table user-list-admin-page-desktop">
            <thead>
                <th class="s-schedule-th">会員番号</th>
                <th class="s-schedule-th">お名前</th>
                <th class="s-schedule-th">Eメール</th>
                <th class="s-schedule-th">会社名</th>
                <th class="s-schedule-th">登録日時</th>
                <th class="s-schedule-th"></th>
                <th class="s-schedule-th"></th>
            </thead>
            <tbody>
                <?php
                foreach($users as $user) { ?>
                <tr>
                    <td class="text-center"><?= $user['member_id'] ?></td>
                    <td class="text-center"><?= $user['name'] ?></td>
                    <td class="text-center"><?= $user['email'] ?></td>
                    <td class="text-center"><?= $user['company'] ?></td>
                    <td class="text-center"><?= substr($user['created_at'], 0, 16) ?></td>
                    <td class="text-center"><div><a class="btn-edit user-control btn" style="float: center;" href="<?= base_url()?>uuser?member=<?= $user['member_id'] ?>"><i class="fa fa-pencil"></i></a></div></td>
                    <td class="text-center"><a class="btn-trash user-control btn" style="float: center !important;" class="member-delete" id="member-d-<?= $user['member_id'] ?>"><i class="fa fa-trash"></i></a></td>
                </tr><?php
                } ?>
            </tbody>
        </table>
        <table class="enquiry-table user-list-admin-page-mobile">
            <thead>
                <th class="s-schedule-th">会員番号</th>
                <th class="s-schedule-th">ユーザー情報</th>
                <th class="s-schedule-th"></th>
                <th class="s-schedule-th"></th>
            </thead>
            <tbody>
                <?php
                foreach($users as $user) { ?>
                <tr>
                    <td class="text-center"><?= $user['member_id'] ?></td>
                    <td class="text-center">
                      <?= $user['name'] ?><br>
                      <?= $user['email'] ?><br>
                      <?= $user['company'] ?><br>
                      <?= substr($user['created_at'], 0, 16) ?>
                    </td>
                    <td class="text-center"><div><a class="btn-edit user-control btn" style="float: center;" href="<?= base_url()?>uuser?member=<?= $user['member_id'] ?>"><i class="fa fa-pencil"></i></a></div></td>
                    <td class="text-center"><a class="btn-trash user-control btn" style="float: center !important;" class="member-delete" id="member-d-<?= $user['member_id'] ?>"><i class="fa fa-trash"></i></a></td>
                </tr><?php
                } ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<script>
  $(document).on('click', '.member-delete i', function(){
    alert('hi');
  })
</script>