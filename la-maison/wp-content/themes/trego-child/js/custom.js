/**
 * Created by Oleg on 03/10/2016.
 */

jQuery( document ).ready(function() {
	var pathname = window.location.pathname;
	//alert(pathname);
	if (pathname != "/la-maison/")
	{
		jQuery(".menu-item > a").each(function ()
		{
			linkurl = jQuery(this).attr("href");
			if (linkurl == "/la-maison/la-maison-weiss/")
			{
				jQuery(this).parent().parent().parent().find("h5").click();
			}
		});
	}
});
