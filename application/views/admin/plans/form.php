<form method="post" class="space-y-4">
 <input type="hidden" 
        name="<?= $this->security->get_csrf_token_name(); ?>" 
        value="<?= $this->security->get_csrf_hash(); ?>" />
		
		
		<?php  // echo "<pre>"; print_r($plan); die; ?>
  <div>
    <label class="block mb-1">Plan Name</label>
    <input type="text" name="name"
           value="<?= $plan->name ?? '' ?>"
           class="w-full bg-black border border-border rounded px-3 py-2">
  </div>

  <div>
    <label class="block mb-1">Price</label>
    <input type="text" name="price"
           value="<?= $plan->price ?? '' ?>"
           class="w-full bg-black border border-border rounded px-3 py-2">
  </div>

  <div>
    <label class="block mb-1">Duration</label>
    <select name="duration" class="w-full bg-black border border-border rounded px-3 py-2">
      <option value="daily" <?= (isset($plan) && $plan->duration=='daily')?'selected':'' ?>>Daily</option>
      <option value="monthly" <?= (isset($plan) && $plan->duration=='monthly')?'selected':'' ?>>Monthly</option>
      <option value="yearly" <?= (isset($plan) && $plan->duration=='yearly')?'selected':'' ?>>Yearly</option>
    </select>
  </div>

  <!-- Features -->
  <div>
    <label class="block mb-1">Features</label>

    <div id="features">
      <?php if(!empty($plan->features)): ?>
        <?php foreach($plan->features as $f): ?>
          <div class="flex gap-2 mb-2">
            <input type="text" name="features[]"
                   value="<?= $f->feature_name ?>"
                   class="w-full bg-black border border-border rounded px-3 py-2">
            <button type="button" onclick="this.parentNode.remove()">X</button>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <input type="text" name="features[]"
               class="w-full bg-black border border-border rounded px-3 py-2">
      <?php endif; ?>
    </div>

    <button type="button" onclick="addFeature()"
            class="mt-2 text-primary text-sm">+ Add Feature</button>
  </div>

  <!-- Status -->
  <div>
    <label>Status</label>
    <select name="status" class="w-full bg-black border border-border rounded px-3 py-2">
      <option value="active" <?= (isset($plan) && $plan->status=='active')?'selected':'' ?>>Active</option>
      <option value="inactive" <?= (isset($plan) && $plan->status=='inactive')?'selected':'' ?>>Inactive</option>
    </select>
  </div>

  <button type="submit"
          class="bg-primary px-4 py-2 rounded text-white">
    Save Plan
  </button>

</form>

<script>
function addFeature(){
  let html = `<div class="flex gap-2 mb-2">
    <input type="text" name="features[]" class="w-full bg-black border border-border rounded px-3 py-2">
    <button type="button" onclick="this.parentNode.remove()">X</button>
  </div>`;
  document.getElementById('features').insertAdjacentHTML('beforeend', html);
}
</script>