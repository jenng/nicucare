<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') )
{
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

if ( ! class_exists( 'RWMB_Taxo_Field' ) )
{
	class RWMB_Taxo_Field
	{
		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			if ( ! is_array( $meta ) )
				$meta = (array) $meta;

			$html = array();

			$category = $field['taxonomy']; 
			$terms = get_terms($category);
			
			$i = 0;
			foreach ( $terms as $term ) 
			{
				$key = $term->slug;
				$key_name = $term->name;
				$checked = checked( in_array( $key, $meta ), true, false );
				$name = "name='{$field['field_name']}[$i]'";
				$val     = " value='{$key}'";
				$html[]  = "<label><input type='checkbox' class='rwmb-checkbox-list'{$name}{$val}{$checked} /> {$key_name}</label>";
				$i++;
			}
			return implode( '<br />', $html );
		}
	}
}