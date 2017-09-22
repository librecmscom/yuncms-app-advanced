<?php

 ?>

<div style="background:#ececec;width: 100%;padding: 50px 0;text-align:center;">
    <div style="background:#fff;width:750px;text-align:left;position:relative;margin:0 auto;font-size:14px;line-height:1.5;">
        <div style="zoom:1;padding:25px 40px;background:#518bcb; border-bottom:1px solid #467ec3;">
            <h1 style="color:#fff; font-size:25px;line-height:30px; margin:0;"><a href="' . get_option('home') . '" style="text-decoration: none;color: #FFF;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</a></h1>
        </div>
        <div style="padding:35px 40px 30px;">
            <h2 style="font-size:18px;margin:5px 0;">Hi ' . trim($comment->comment_author) . ':</h2>
            <p style="color:#313131;line-height:20px;font-size:15px;margin:20px 0;">您有一条留言通过了管理员的审核并显示在文章页面，摘要信息请见下表。</p>
            <table cellspacing="0" style="font-size:14px;text-align:center;border:1px solid #ccc;table-layout:fixed;width:500px;">
                <thead>
                <tr>
                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="280px;">文章</th>
                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="270px;">内容</th>
                    <th style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:normal;color:#a0a0a0;background:#eee;border-color:#dfdfdf;" width="110px;" >操作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">《' . get_the_title($comment->comment_post_ID) . '》</td>
                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'. trim($comment->comment_content) . '</td>
                    <td style="padding:5px 0;text-indent:8px;border:1px solid #eee;border-width:0 1px 1px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="'.get_comment_link( $comment->comment_ID ).'" style="color:#1E5494;text-decoration:none;vertical-align:middle;" target="_blank">查看留言</a></td>
                </tr>
                </tbody>
            </table>
            <br>
            <div style="font-size:13px;color:#a0a0a0;padding-top:10px">该邮件由系统自动发出，如果不是您本人操作，请忽略此邮件。</div>
            <div class="qmSysSign" style="padding-top:20px;font-size:12px;color:#a0a0a0;">
                <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;">' . htmlspecialchars_decode(get_option('blogname'), ENT_QUOTES) . '</p>
                <p style="color:#a0a0a0;line-height:18px;font-size:12px;margin:5px 0;"><span style="border-bottom:1px dashed #ccc;" t="5" times="">' . date("Y年m月d日",time()) . '</span></p>
            </div>
        </div>
    </div>
</div>
