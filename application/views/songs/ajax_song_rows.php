<?php foreach ($songs as $song): ?>
<tr class="border-t border-zinc-800">
    <td class="px-4 py-3"><?php echo $song->song_title; ?></td>
    <td class="px-4 py-3 text-gray-400"><?php echo $song->genre; ?></td>
    <td class="px-4 py-3 text-gray-400"><?php echo $song->duration; ?></td>
    <td class="px-4 py-3 text-gray-400">
        <?php echo date('M d, Y', strtotime($song->created_at)); ?>
    </td>
    <td class="px-4 py-3">
        <audio controls class="w-40">
            <source src="<?php echo base_url('uploads/singles/' . $song->audio_file); ?>">
        </audio>
    </td>
</tr>
<?php endforeach; ?>
