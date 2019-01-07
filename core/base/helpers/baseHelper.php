<?php
if (!function_exists('testHelper')) {
    /**
     * @author TrinhLe
     */
    function testHelper()
    {
        return view('core-base::base')->render();
    }
}

if (function_exists('showImgStorage') === false) {
	/**
	 * Get image
	 * @param type $image 
	 * @param type|string $default
	 * @author TrinhLe 
	 * @return string
	 */
    function showImgStorage($image, $default = 'system/images/default-avatar.png')
    {
        if(!empty($image))
        	return "/storage/{$image}";

        if($default !== false)
            return "/storage/{$default}";
    }
}