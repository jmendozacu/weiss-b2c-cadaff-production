(function() {
	tinymce.PluginManager.add('shortcodes', function(editor, url) {
		editor.addButton('shortcodes', {
		    type: 'listbox',
		    text: 'Shortcodes',
		    icon: false,
			tooltip: 'Insert Shortcode',
			fixedWidth: true,
		    onselect: function(e) {
		    	editor.focus();
		    	tinymce.execCommand('mceInsertContent', false, this.value());
		    }, 
		    values: [
				{text: "Tabs", value: '[tabgroup title="Tab title" tab_position="left"]<br>[tab title="Tab 1 Title"] Tab content 1 [/tab]<br>[tab title="Tab 2 Title"] Tab content 2 [/tab]<br>[tab title="Tab 3 Title"] Tab content 3 [/tab]<br>[/tabgroup]'},
				{text: "Accordian", value: '[accordion title="Accordian title" toggle="false" toggle_position="right"]<br><br>[accordion_item title="Item 1 Title"]<br>Accordion Item 1 Content...<br>[/accordion_item]<br><br>[accordion_item title="Item 2 Title"]<br>Accordion Item 2 Content...<br>[/accordion_item]<br><br>[accordion_item title="Item 3 Title"]<br> Accordion Item 3 Content...<br> [/accordion_item]<br><br>[/accordion]'},
				{text: "Title", value: '[title text="This is a title" text_align="left" link="http://"]'},
				{text: "Divider", value: '[divider width="50px" color="#D5D5D5"]'},
				{text: "Button", value: '[button text="Button text" link="http://"]'},
				{text: "Banner", value: '[banner bground="http://" animation="fadeIn"]<h1>- SLIDER EXAMPLE -</h1>[/banner]'},
				{text: "Google map", value: '[gmap lat="40.79028" long="-73.95972" height="300px"]'},
				{text: "Social Links", value: '[social_link facebook="http://" twitter="http://" linkedin="http://" flickr="http://" googleplus="http://"]'},
				{text: "Youtube Link", value: '[youtube vid="video-id"]'},
				{text: "Vimeo Link", value: '[vimeo vid="video-id"]'},
				{text: "Portfolio", value: '[portfolio columns="3" show_title="false" ajax="false"]'},
				{text: "Team Member", value: '[team_member name="Name" title="Title" img="http://imageurl" facebook="http://" twitter="http://" linkedin="http://" flickr="http://" googleplus="http://" text_align="center"]<br>Team member description<br>[/team_member]'},
				{text: "Team Member Slider", value: '[bxslider title="Meet our Team" max_slides="3" move_slides="3" slide_margin="20" ctrls_pos="top" class="member-slider"]<br>[member_slide name="Name" title="Title" img="http://imageurl" facebook="http://" twitter="http://" linkedin="http://" flickr="http://" googleplus="http://" text_align="center"]<br>Team member description<br>[/member_slide]<br>[/bxslider]'},
				{text: "Testimonials Slider", value: '[testimonial title="Testimonial" limit="3" max_slides="2"]'},
				{text: "Recent Projects Slider", value: '[recent_portfolio title="Recent Projects:"]'},
				{text: "bxSlider", value: '[bxslider loop="true"]<br>[slide bground="http://"]<h1>- SLIDER EXAMPLE -</h1>[/slide]<br>[/bxslider]'},
				{text: "Home Slider", value: '[home_slider]<br>[bgslide title="" img="http://"]<br>- CONTENTS -<br>[/bgslide]<br>[/home_slider]'},
				{text: "Product Slider - Bestseller", value: '[bestseller_products_slider title="Our Bestsellers"]'},
				{text: "Product Slider - Latest", value: '[latest_products_slider title="Our Latest Products"]'},
				{text: "Product Slider - Featured", value: '[featured_products_slider title="Our Featured Products"]'},
				{text: "Product Slider - On Sale", value: '[sale_products_slider title="Our Products on Sale"]'},
				{text: "Row - 2 columns", value: '[row] <br> [col span="1/2"] Col 1 [/col] <br> [col span="1/2"] Col 2 [/col] <br> [/row]'},
				{text: "Row - 3 Columns", value: '[row] <br> [col span="1/3"] Col 1 [/col] <br> [col span="1/3"] Col 2 [/col] <br> [col span="1/3"] Col 3 [/col] <br> [/row]'},
				{text: "Row - 4 Columns", value: '[row] <br> [col span="1/4"] Col 1 [/col]  <br>[col span="1/4"] Col 2 [/col] <br> [col span="1/4"] Col 3 [/col] <br> [col span="1/4"] Col 4 [/col] <br> [/row]'},
				{text: "Section", value: '[section title=""]<br>[section_description]<br> ... ... ... <br>[/section_description]<br> ... ... ... <br>[/section]'},
				{text: "Section - Icon Block", value: '[icon_block icon="" title="" type="horizontal"] ... [/icon_block]'},
				{text: "Section - Progress Bar", value: '[progress_bar label="" percent=""]'},
				{text: "Section - Testimonial", value: '[section_testimonial limit="4"]'},
		    ]
		});
		editor.addButton('blocks', {
		    type: 'listbox',
		    text: 'Blocks',
		    icon: false,
			tooltip: 'Insert Block',
			fixedWidth: true,
		    onselect: function(e) {
		    	editor.focus();
		    	tinymce.execCommand('mceInsertContent', false, this.value());
		    }, 
		    values: block_shortcodes
		});
	});
})();