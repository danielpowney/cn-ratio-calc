<?php
?>
<form class="cnrc-form">
	<div class="cnrc-unit">
		<label>Unit</label>
		<select id="unit">
			<option value="oz">Ounces</option>
			<option value="lbs">Pounds</option>
			<option value="g">Grams</option>
			<option value="kg">Kilograms</option>
		</select>
	</div>
	<div id="cnrc-form-item-1" class="cnrc-form-item">
		<div class="cnrc-item-details">
        	<div class="cnrc-item-type">
		        <select id="item">
		            <option value="25">Garden waste</option>
		            <option value="12">Vegetable scraps</option>
		            <option value="15">Food scraps</option>
		            <option value="15">Manures</option>
		            <option value="40">Fruits</option>
		            <option value="20">Coffee grounds</option>
		            <option value="20">Grass clippings</option>
		            <option value="35">Fruit waste (e.g. banana skin)</option>
		            <option value="58">Peat moss</option>
		            <option value="60">Leaves</option>
		            <option value="75">Straw</option>
		            <option value="175">Shredded newspaper</option>
		            <option value="400">Wood chips</option>
		            <option value="350">Shredded carboard</option>
		            <option value="325">Sawdust</option>
		        </select>
		    </div>
        	<div class="cnrc-item-quantity">
        		<input type="number" min=1 />
        		<label>grams</label>
        	</div>
        	<span class="cnrc-item-add dashicons dashicons-plus-alt"></span>
	</div>
</div>
<div id="cnrc-result">
	<span id="cnrc-result-carbon">?</span>:1</span>
</div>