<?php

function _form_row( $name, $label, $value = NULL, $type = 'text', $options = array() ){
	$rand = rand(10000,99999);
	if( 'text' == $type ):
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th scope="row"><label for="frm_<?php echo $name; ?>"><?php echo $label; ?></label></th>
				<td><input type="text" id="frm_<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" /></td>
			</tr>
		<?php
	elseif( 'textarea' == $type ):
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th scope="row"><label for="frm_<?php echo $name; ?>"><?php echo $label; ?></label></th>
				<td><textarea id="frm_<?php echo $name; ?>" name="<?php echo $name; ?>"><?php echo $value; ?></textarea></td>
			</tr>
		<?php
	elseif( 'dropdown' == $type ):
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th scope="row"><label for="frm_<?php echo $name; ?>"><?php echo $label; ?></label></th>
				<td><select id="frm_<?php echo $name; ?>" name="<?php echo $name; ?>">
					<?php if( is_array( $options ) && $options ): foreach( $options as $option ): ?>
						<option<?php if( $option == $value ) echo ' selected="selected"'; ?>><?php echo $option; ?></option>
					<?php endforeach; endif; ?>
					</select></td>
			</tr>
		<?php
	elseif( 'dropdown_assoc' == $type ):
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th scope="row"><label for="frm_<?php echo $name; ?>"><?php echo $label; ?></label></th>
				<td><select id="frm_<?php echo $name; ?>" name="<?php echo $name; ?>">
					<?php if( is_array( $options ) && $options ): foreach( $options as $option => $label ): ?>
						<option value="<?php echo $option; ?>" <?php if( $option == $value ) echo ' selected="selected"'; ?>><?php echo $label; ?></option>
					<?php endforeach; endif; ?>
					</select></td>
			</tr>
		<?php
	elseif( 'checkboxes' == $type ):
		if( $value ){
			if( is_array( $value ) ){
				$values = $value;
			}else{
				$values = unserialize( $value );
			}
		}else{
			$values = array();
		}
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th scope="row"><label><?php echo $label; ?></label></th>
				<td><ul>
					<?php if( is_array( $options ) && $options ): foreach( $options as $option ): ?>
					<li><label style="text-align:left;"><input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $option; ?>" <?php if( in_array( $option, $values ) ) echo ' checked="checked"'; ?> style="width:auto;"> <?php echo $option; ?></label></li>
					<?php endforeach; endif; ?>
				</ul></td>
			</tr>
		<?php
	elseif( 'checkboxes_assoc' == $type ):
		if( $value ){
			if( is_array( $value ) ){
				$values = $value;
			}else{
				$values = unserialize( $value );
			}
		}else{
			$values = array();
		}
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th><label><?php echo $label; ?></label></th>
				<td><ul>
					<?php if( is_array( $options ) && $options ): foreach( $options as $option => $label ): ?>
					<li><label style="text-align:left;"><input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $option; ?>" <?php if( in_array( $option, $values ) ) echo ' checked="checked"'; ?> style="width:auto;"> <?php echo $label; ?></label></li>
					<?php endforeach; endif; ?>
				</ul></td>
			</tr>
		<?php
	elseif( 'display' == $type ):
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th scope="row"><label><?php echo $label; ?></label></th>
				<td><?php echo $value; ?></td>
			</tr>
		<?php
	elseif( 'hidden' == $type ):
		?>	<input type="hidden" id="frm_<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
		<?php
	elseif( 'submit' == $type ):
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<td></td>
				<td><button type="submit" class="button button-primary"><?php echo $value; ?></button></td>
			</tr>
		<?php
	elseif( 'tel' == $type ):
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th scope="row"><label for="frm_<?php echo $name; ?>"><?php echo $label; ?></label></th>
				<td><input type="tel" id="frm_<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" onChange="this.value=this.value.replace(/\D/g,'').replace(/^(\d{3})(\d{3})/,'($1) $2 - ')" /></td>
			</tr>
		<?php
	else:
		?>	<tr id="form-row-<?php echo $name; ?>" class="form-row form-row-<?php echo $type; ?>">
				<th scope="row"><label for="frm_<?php echo $name; ?>"><?php echo $label; ?></label></th>
				<td><input type="<?php echo $type; ?>" id="frm_<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" /></td>
			</tr>
		<?php
	endif;
	return TRUE;
}