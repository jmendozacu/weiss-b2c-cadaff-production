(function() {
	tinymce.create('tinymce.plugins.ShortcodeMce', {
		init : function(ed, url){
			tinymce.plugins.ShortcodeMce.theurl = url;
		},
		createControl : function(btn, e) {
			if ( btn == "shortcodes" ) {
				var a = this;	
				var btn = e.createSplitButton('button', {
	                title: "Insert Shortcode",
					image: tinymce.plugins.ShortcodeMce.theurl +"/images/shortcodes.png",
					icons: false,
	            });
	            btn.onRenderMenu.add(function (c, b) {
	            	
					a.render( b, "Tabs", "tabs" );
					a.render( b, "Accordian", "accordian" );
					a.render( b, "Title", "title" );
                    a.render( b, "Divider", "divider" );
					a.render( b, "Button", "button" );
					a.render( b, "Banner", "banner" );
					a.render( b, "Google map", "google_map" );
					a.render( b, "Social Links", "social_link" );
					a.render( b, "Youtube Link", "youtube" );
					a.render( b, "Vimeo Link", "vimeo" );
					a.render( b, "Team Member", "team_member" );
					a.render( b, "Team Member Slider", "team_member_slider" );
					a.render( b, "Testimonials Slider", "testimonial" );
                    a.render( b, "Recent Projects Slider", "recent_projects" );
					a.render( b, "bxSlider", "bxslider" );
					a.render( b, "Home Slider", "home_slider" );
					a.render( b, "Product Slider - Bestseller", "bestseller_products_slider" );
					a.render( b, "Product Slider - Latest", "latest_products_slider" );
					a.render( b, "Product Slider - Featured", "featured_products_slider" );
					a.render( b, "Product Slider - On Sale", "sale_products_slider" );
					a.render( b, "Row - 2 columns", "row_2" );
					a.render( b, "Row - 3 Columns", "row_3" );
					a.render( b, "Row - 4 Columns", "row_4" );

				});
	            
	          return btn;
			}
            if(btn=='blocks'){
                var mlb = e.createListBox('block', {
                     title : 'Blocks',
                     onselect : function(v) {
                     	if(tinyMCE.activeEditor.selection.getContent() == ''){
                            tinyMCE.activeEditor.selection.setContent( v )
                        }
                     }
                });
 
                for(var i in block_shortcodes)
                	mlb.add(block_shortcodes[i],block_shortcodes[i]);
 
                return mlb;
            }
			return null;               
		},
		render : function(ed, title, id) {
			ed.add({
				title: title,
				onclick: function () {
								
					if(id == "banner") {
						tinyMCE.activeEditor.selection.setContent('[banner bground="http://" animation="fadeIn"]<h1>- SLIDER EXAMPLE -</h1>[/banner]');
					}

					if(id == "bxslider") {
						tinyMCE.activeEditor.selection.setContent('[bxslider loop="true"]<br>[slide bground="http://"]<h1>- SLIDER EXAMPLE -</h1>[/slide]<br>[/bxslider]');
					}

					if(id == "home_slider") {
						tinyMCE.activeEditor.selection.setContent('[home_slider]<br>[bgslide title="" img="http://"]<br>- CONTENTS -<br>[/bgslide]<br>[/home_slider]');
					}

					if(id == "row_4") {
						tinyMCE.activeEditor.selection.setContent('[row] <br> [col span="1/4"] Col 1 [/col]  <br>[col span="1/4"] Col 2 [/col] <br> [col span="1/4"] Col 3 [/col] <br> [col span="1/4"] Col 4 [/col] <br> [/row]');
					}

					if(id == "row_3") {
						tinyMCE.activeEditor.selection.setContent('[row] <br> [col span="1/3"] Col 1 [/col] <br> [col span="1/3"] Col 2 [/col] <br> [col span="1/3"] Col 3 [/col] <br> [/row]');
					}

					if(id == "row_2") {
						tinyMCE.activeEditor.selection.setContent('[row] <br> [col span="1/2"] Col 1 [/col] <br> [col span="1/2"] Col 2 [/col] <br> [/row]');
					}

					if(id == "button") {
						tinyMCE.activeEditor.selection.setContent('[button text="Button text" link="http://"]');
					}

					if(id == "tabs") {
						tinyMCE.activeEditor.selection.setContent('[tabgroup title="Tab title" tab_position="left"]<br>[tab title="Tab 1 Title"] Tab content 1 [/tab]<br>[tab title="Tab 2 Title"] Tab content 2 [/tab]<br>[tab title="Tab 3 Title"] Tab content 3 [/tab]<br>[/tabgroup]');
					}

					if(id == "accordian") {
						tinyMCE.activeEditor.selection.setContent('[accordion title="Accordian title" toggle="false" toggle_position="right"]<br><br>[accordion_item title="Item 1 Title"]<br>Accordion Item 1 Content...<br>[/accordion_item]<br><br>[accordion_item title="Item 2 Title"]<br>Accordion Item 2 Content...<br>[/accordion_item]<br><br>[accordion_item title="Item 3 Title"]<br> Accordion Item 3 Content...<br> [/accordion_item]<br><br>[/accordion]');
					}
					
					if(id == "google_map") {
						tinyMCE.activeEditor.selection.setContent('[gmap lat="40.79028" long="-73.95972" height="300px"]');
					}

					if(id == "social_link") {
						tinyMCE.activeEditor.selection.setContent('[social_link facebook="http://" twitter="http://" linkedin="http://" flickr="http://" googleplus="http://"]');
					}

					if(id == "team_member") {
						tinyMCE.activeEditor.selection.setContent('[team_member name="Name" title="Title" img="http://imageurl" facebook="http://" twitter="http://" linkedin="http://" flickr="http://" googleplus="http://" text_align="center"]<br>Team member description<br>[/team_member]');
					}

					if(id == "team_member_slider") {
						tinyMCE.activeEditor.selection.setContent('[bxslider title="Meet our Team" max_slides="3" move_slides="3" slide_margin="20" ctrls_pos="top" class="member-slider"]<br>[member_slide name="Name" title="Title" img="http://imageurl" facebook="http://" twitter="http://" linkedin="http://" flickr="http://" googleplus="http://" text_align="center"]<br>Team member description<br>[/member_slide]<br>[/bxslider]');
					}

                    if(id == "recent_projects") {
                        tinyMCE.activeEditor.selection.setContent('[recent_portfolio title="Recent Projects:"]');
                    }

					if(id == "testimonial") {
						tinyMCE.activeEditor.selection.setContent('[testimonial title="Testimonial" limit="3" max_slides="2"]');
					}

                    if(id == "title") {
                        tinyMCE.activeEditor.selection.setContent('[title text="This is a title" text_align="left" link="http://"]');
                    }

                    if(id == "divider") {
                        tinyMCE.activeEditor.selection.setContent('[divider width="50px" color="#D5D5D5"]');
                    }

					if(id == "bestseller_products_slider") {
						tinyMCE.activeEditor.selection.setContent('[bestseller_products_slider title="Our Bestsellers"]');
					}

					if(id == "featured_products_slider") {
						tinyMCE.activeEditor.selection.setContent('[featured_products_slider title="Our Featured Products"]');
					}

					if(id == "sale_products_slider") {
						tinyMCE.activeEditor.selection.setContent('[sale_products_slider title="Our Products on Sale"]');
					}

					if(id == "latest_products_slider") {
						tinyMCE.activeEditor.selection.setContent('[latest_products_slider title="Our Latest Products"]');
					}

					if(id == "youtube") {
						tinyMCE.activeEditor.selection.setContent('[youtube vid="video-id"]');
					}

					if(id == "vimeo") {
						tinyMCE.activeEditor.selection.setContent('[vimeo vid="video-id"]');
					}
					return false;
				}
			})
		}
	
	});
	tinymce.PluginManager.add("shortcodes", tinymce.plugins.ShortcodeMce);
})();
