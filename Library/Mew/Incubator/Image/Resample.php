<?php

class Mew_Incubator_Image_Resample
{
	function resample( $source, $destination, $width, $height, $keep_ratio = false, $keep_size = true )
	{
		if ( !function_exists('getimagesize'))
		{
			throw new exception('GD library is required');
			return false;
		}
	
		$size = getimagesize( $source );
	
		if (!$size[0] || !$size[1])
		{
			throw new exception('size of image cannot be determined');
			return false;
		}
	
		if ( $keep_ratio )
		{
			$dest_width        = $width;
			$dest_height       = $height;
			$source_ratio      = $size[0] / $size[1];
			$destination_ratio = $width / $height;
			$start_x           = 0;
			$start_y           = 0;
	
			if ( $source_ratio > $destination_ratio )
			{
				$height = (int)$dest_width / $source_ratio;

				if ( $keep_size )
				{
					$start_y += ($dest_height - $height) / 2;
				}
			}
			else if ( $source_ratio < $destination_ratio )
			{
				$width = (int)$dest_height * $source_ratio;

				if ( $keep_size )
				{
					$start_x += ($dest_width - $width) / 2;
				}
			}
	
			if ( !$keep_size )
			{
				$dest_width  = $width;
				$dest_height = $height;
			}
		}
	
		$dest_image = imagecreatetruecolor( $dest_width, $dest_height );
		$white      = imagecolorallocate( $dest_image, 255, 255, 255 );
		imagefill( $dest_image, 0, 0, $white );
		imagefilledrectangle( $dest_image, 0, 0, $dest_width, $dest_height, $white );
	
		switch ( $size[2] )
		{
			case IMAGETYPE_JPEG:
			{
				$src_image = imagecreatefromjpeg( $source );
				break;
			}
			case IMAGETYPE_PNG:
			{
				$src_image = imagecreatefrompng( $source );
				break;
			}
			default:
			{
				throw new exception('unsupported image type');
				return false;
			}
		}
	
		imagecopyresampled(
			$dest_image, $src_image, $start_x, $start_y, 0, 0,
			$width, $height, $size[0], $size[1]
		);
	
		if ( !imagejpeg( $dest_image, $destination ) )
		{
			throw new exception('resampling failed');
			return false;
		}
	
		return true;
	}
}

