function get_blox_element_blog($content, $attrs){
    $tools = '<div class="blox_item_actions"> \
                    <a href="javascript:;" class="icon-pencil action_edit"></a> \
                    <a href="javascript:;" class="icon-copy action_clone"></a> \
                    <a href="javascript:;" class="icon-remove action_remove"></a> \
            </div>';
    return '<div class="blox_item blox_blog" '+($attrs!=undefined ? $attrs : '')+'> \
                <div class="blox_item_title"> \
                        <i class="icon-user"></i> \
                        <span class="blox_item_title">Blog Element</span> \
                        '+$tools+' \
                </div> \
                <div class="blox_item_content" style="display: none;"></div> \
			</div>';
    
}


function parse_shortcode_blog($content){
    $content = wp.shortcode.replace( 'blox_blog', $content, function(data){
        var attrs = '';
        jQuery.each(data.attrs.named, function(key, value){
	
            if( key=='title' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='style' && value!='undefined' ){
                attrs += 'blog_style="'+value+'" ';
            }
            if( key=='categories' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='blog_filter' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='content' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='readmore' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='count' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }     
            if( key=='pager' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='filter' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='ignoresticky' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='overlay' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }     
            if( key=='exclude' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }     
            if( key=='order' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }     
            if( key=='skip' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='extra_class' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
            if( key=='skin' && value!='undefined' ){
                attrs += key+'="'+value+'" ';
            }
        })
        return get_blox_element_blog(jQuery('<div class="tmp_pass">'+attrs+'</div>'), attrs);
    });
    return $content;
}


function revert_shortcode_blog($content){
    $content.find('.blox_blog').each(function(){
        attr = '';
        var temp_val = '';

        temp_val = jQuery(this).attr('title')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' title="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('blog_style')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' style="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('categories')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' categories="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('blog_filter')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' blog_filter="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('content')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' content="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('readmore')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' readmore="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('count')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' count="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('pager')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' pager="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('filter')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' filter="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('ignoresticky')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' ignoresticky="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('overlay')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' overlay="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('exclude')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' exclude="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('order')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' order="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('skip')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' skip="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('extra_class')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' extra_class="'+temp_val+'"';
        }
        temp_val = jQuery(this).attr('skin')+'';
        if( temp_val!='undefined' && temp_val!='' ){
            attr += ' skin="'+temp_val+'"';
        }
		
        jQuery(this).replaceWith('[blox_blog'+attr+'/]');
    });
    return $content;
}


function add_event_blox_element_blog(){
	
    jQuery('.blox_blog').each(function(){
        var $this = jQuery(this);
		
        $this.find('.blox_item_actions .action_edit').unbind('click')
        .click(function(){

            var form_element = [
            {
                type: 'input',
                id: 'blog_title',
                label: 'Title',
                value: $this.attr('title')
            },
            {
                type: 'select',
                id: 'blog_style',
                label: 'Blog Style',
                value: (typeof $this.attr('blog_style')!=='undefined' ? $this.attr('blog_style') : 'regular'),
                options: [
                    { value: 'regular', label: '1. Regular' },
                    { value: 'metro', label: '2. Metro style' },
                    { value: 'centered', label: '3. Centered' },
                    { value: 'leftimage', label: '4. Left image' },
                    { value: 'rightimage', label: '5. Right image' },
                    { value: 'grid2', label: '6. Grid 2 columns' },
                    { value: 'grid3', label: '7. Grid 3 columns' },
                    { value: 'grid4', label: '8. Grid 4 columns' },
                    { value: 'masonry2', label: '9. Masonry 2 columns' },
                    { value: 'masonry3', label: '10. Masonry 3 columns' },
                    { value: 'masonry4', label: '11. Masonry 4 columns' }
                ]
            },
            {
                type: 'select',
                id: 'blog_categories',
                label: 'Post Filter',
                value: $this.attr('categories'),
                options: [
                    { value: 'all', label: 'All' },
                    { value: 'categories', label: 'Categories' },
                    { value: 'tags', label: 'Tags' },
                    { value: 'format', label: 'Post Formats' }
                ],
                description: 'Select a type of post filter.'

            },
            {
                type: 'select',
                id: 'blox_elem_multi_category',
                label: 'Choose Categories',
                value: '',
                options: [
                    { value: 'all', label: 'All' },
                ]

            },
            {
                type: 'select',
                id: 'blox_elem_multi_tags',
                label: 'Choose Tags',
                value: '',
                options: [
                    { value: 'all', label: 'All' },
                ]

            },
            {
                type: 'select',
                id: 'blox_elem_multi_formats',
                label: 'Choose Post Formats',
                value: '',
                options: [
                    { value: 'all', label: 'All' },
                ]

            },
            {
                type: 'select',
                id: 'blog_content',
                label: 'Post Content',
                value: $this.attr('content'),
                options: [
                    { value: 'both', label: 'Excerpt + Read more link' },
                    { value: 'content', label: 'Full content' },
                    { value: 'excerpt', label: 'Excerpt' },
                    { value: 'nocontent', label: 'No content' }
                ]

            },
            {
                type: 'input',
                id: 'blog_readmore',
                label: 'Read more text',
                value: $this.attr('readmore'),
                description: 'Read more button text. Default: Read more'
            },
            {
                type: 'number',
                id: 'blog_count',
                std: 10,
                label: 'Post count',
                value: $this.attr('count')
            },
            {
                type: 'checkbox_flat',
                id: 'blog_pager',
                label: 'Show Pagination',
                value: $this.attr('pager'),
                options: [
                    { value: 'yes', label: 'Yes' },
                    { value: 'no', label: 'No' }
                ]

            },
            {
                type: 'checkbox_flat',
                id: 'blog_filter',
                label: 'Show Post Filter',
                value: $this.attr('filter'),
                options: [
                    { value: 'no', label: 'No' },
                    { value: 'yes', label: 'Yes' }
                ]

            },
            {
                type: 'select',
                id: 'blog_overlay',
                label: 'Image overlay type',
                value: $this.attr('overlay'),
                options: [
                    { value: 'permalink', label: 'Permalink' },
                    { value: 'lightbox', label: 'Lightbox' },
                    { value: 'both', label: 'Permalink & Lightbox buttons' }
                ]

            },
            {
                type: 'input',
                id: 'blog_exclude',
                label: 'Exclude posts',
                value: $this.attr('exclude'),
                description: 'Please add post IDs with comma separator. Example: 125,1,65'
            },
            {
                type: 'select',
                id: 'blog_order',
                label: 'Order type',
                value: $this.attr('order'),
                options: [
                    { value: 'default', label: 'Date' },
                    { value: 'dateasc', label: 'Date Ascending' },
                    { value: 'titleasc', label: 'Title Ascending' },
                    { value: 'titledes', label: 'Title Descending' },
                    { value: 'comment', label: 'Most Commented' },
                    { value: 'postid', label: 'Post ID' }
                ]
            },
            {
                type: 'number',
                id: 'blog_skip',
                std: 0,
                label: 'Skip count',
                value: $this.attr('skip'),
                description: 'This option helps you to skip X number of posts & prevent duplication If you use Blog element on this page twice or multiple times.'
            },
            {
                type: 'input',
                id: 'blog_class',
                label: 'Extra Class',
                value: $this.attr('extra_class')
            }
            ];


            show_blox_form('Edit Blog', form_element, function($form){
                $this.attr('title', jQuery('#blog_title').val());
                $this.attr('blog_style', jQuery('#blog_style').val());
                $this.attr('categories', jQuery('#blog_categories').val());
                $this.attr('content', jQuery('#blog_content').val());
                $this.attr('readmore', jQuery('#blog_readmore').val());
                $this.attr('count', jQuery('#blog_count').val());
                $this.attr('pager', jQuery('#blog_pager').val());
                $this.attr('filter', jQuery('#blog_filter').val());
                $this.attr('ignoresticky', jQuery('#blog_ignoresticky').val());
                $this.attr('overlay', jQuery('#blog_overlay').val());
                $this.attr('exclude', jQuery('#blog_exclude').val());
                $this.attr('order', jQuery('#blog_order').val());
                $this.attr('skip', jQuery('#blog_skip').val());
                $this.attr('extra_class', jQuery('#blog_class').val());

                var el_val = jQuery('#blog_categories').val();
                if( el_val=='categories' ){
                    var sval = jQuery('#blox_new_cats').select2('val');
                    var rval = '';
                    for (var i = 0; i < sval.length; i++) {
                        rval += (i==0 ? sval[i] : ','+sval[i]);
                    }
                    $this.attr('blog_filter', rval);
                }
                else if( el_val=='tags' ){
                    var sval = jQuery('#blox_new_tags').select2('val');
                    var rval = '';
                    for (var i = 0; i < sval.length; i++) {
                        rval += (i==0 ? sval[i] : ','+sval[i]);
                    }
                    $this.attr('blog_filter', rval);
                }
                else if( el_val=='format' ){
                    var sval = jQuery('#blox_new_formats').select2('val');
                    var rval = '';
                    for (var i = 0; i < sval.length; i++) {
                        rval += (i==0 ? sval[i] : ','+sval[i]);
                    }
                    $this.attr('blog_filter', rval);
                }
                else{
                    $this.attr('blog_filter', '');
                }

            },
            {
                target: $this,
                skin: true
            });
            
            
            jQuery('#blog_categories').parent().append( '<span class="ajax_spinner"></span>' );
            jQuery.post( ajaxurl, { 'action':'get_blox_element_blog', 'filter': jQuery('#blog_categories').val(), 'value': $this.attr('blog_filter') }, function(data){
                if( data != "-1" ){
                    jQuery('#blog_categories').parent().find('.ajax_spinner').remove();

                    jQuery('#blox_elem_multi_category').replaceWith( jQuery(data).find('#blox_new_cats') );
                    jQuery('#blox_elem_multi_tags').replaceWith( jQuery(data).find('#blox_new_tags') );
                    jQuery('#blox_elem_multi_formats').replaceWith( jQuery(data).find('#blox_new_formats') );
                    jQuery('#blox_new_cats').select2({ placeholder: 'Select Categories' });
                    jQuery('#blox_new_tags').select2({ placeholder: 'Select Tags' });
                    jQuery('#blox_new_formats').select2({ placeholder: 'Select Post Formats' });

                    jQuery('#s2id_blox_new_cats, #s2id_blox_new_tags, #s2id_blox_new_formats').parent().hide();

                    jQuery('#blog_categories').unbind('change')
                        .change(function(){
                            var value = jQuery('#blog_categories').val();
                            jQuery('#s2id_blox_new_cats, #s2id_blox_new_tags, #s2id_blox_new_formats').parent().hide();
                            if( value=='categories' ){
                                jQuery('#s2id_blox_new_cats').parent().show();
                            }
                            else if( value=='tags' ){
                                jQuery('#s2id_blox_new_tags').parent().show();
                            }
                            else if( value=='format' ){
                                jQuery('#s2id_blox_new_formats').parent().show();
                            }
                        });

                    jQuery('#blog_categories').change();

                }
            });
            
            // Folds
            jQuery('#blog_content').change(function(){
                if( jQuery('#blog_content').val() == 'both' ){
                    jQuery('#blog_readmore').parent().show();
                }
                else{
                    jQuery('#blog_readmore').parent().hide();
                }
            });
            jQuery('#blog_content').change();
            
        });
			
		
        $this.find('.blox_item_actions .action_clone').unbind('click')
        .click(function(){
            $this.after($this.clone());
            add_event_blox_element_blog();
        });
			
        $this.find('.blox_item_actions .action_remove').unbind('click')
        .click(function(){
            $this.remove();
        });
    });
	
}

