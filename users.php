<?php $posts = get_posts(array('post_type' => 'terms_and_cond')); ?>

<h3>Usuarios que aceptaron los términos y condiciones</h3>
<table id="users_terms_cond">
    <tr>
        <th>ID de Página</th>
        <th>Título de página</th>
        <th>Usuario</th>
    </tr>

<?php foreach($posts as $post): ?>
   <?php
    $metas = get_post_meta($post->ID,'terms_and_cond', true);
     if(!empty($metas)){
        $userids = unserialize($metas);
         foreach($userids as $userid){
             echo '<tr>';
             echo '<td>'.$post->ID.'</td>';
             echo '<td><a href="'.$post->guid.'">'.$post->post_title.'</a></td>';
             echo '<td><a href="'.admin_url('profile.php?user_id='.$userid).'">'.get_userdata($userid)->display_name.'</a></td>';
             echo '</tr>';
         }
    }
    ?>
<?php endforeach; ?>
</table>