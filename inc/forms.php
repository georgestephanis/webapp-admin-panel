<?php

function _form_row( $name, $label, $value = NULL, $type = 'text', $options = array() ){
	$rand = rand(10000,99999);
	if( 'text' == $type ):
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th scope="row"><label for="frm_<?php echo $name; ?>"><?php echo $label; ?></label></th>
				<td><input type="text" id="frm_<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" /></td>
			</tr>
		<?php
	# More to come soon ...
	endif;
	return TRUE;
}