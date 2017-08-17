<?php
class Cienum_Ballotin_Helper_Shortcode extends Mage_Core_Helper_Abstract
{

    /*
    
    LISTE DES SHORTCODES
    Nommer fonctions en c_shortcode_
    Déclarer les shortcodes dans $shortcode_tags

     */
    
    var $shortcode_tags = 
    array(
      'blockwp'                 =>  'shortcode_blocks'
      );


   function shortcode_blocks($attrs,$content=null){
    return isset($attrs['id']) ? Mage::app()->getLayout()->createBlock('cms/block')->setBlockId($attrs['id'])->toHtml() : '';
  }

 
    /*
    
    SYSTEME DE SHORTCODE

     */
    
    function c_format_content($content,$strip=null){
      if($strip){
        $strip = (strpos($strip, ','))? explode(',', $strip) : array($strip);
        $pattern = '<div><span><br><img><strong><b><a><p><i><em><address><blockquote><h1><h2><h3><h4><h5><h6><hr><iframe><ul><li><ol>';
        foreach($strip as $s){
          $pattern = str_replace($s,'',$pattern);
        }
        $content = strip_tags($content,$pattern);
      }

      $content = $this->c_parse_shortcode($content);
      return $content;
    }
    function c_parse_shortcode($content){

      if (empty($this->shortcode_tags) || !is_array($this->shortcode_tags))
       return $content;

     $pattern = $this->get_shortcode_regex();
     return preg_replace_callback( "/$pattern/s", array($this,'do_shortcode_tag'), $content );
   }


   function get_shortcode_regex() {
     $tagnames = array_keys($this->shortcode_tags);
     $tagregexp = join( '|', array_map('preg_quote', $tagnames) );

         // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
         // Also, see shortcode_unautop() and shortcode.js.
     return
                   '\\['                              // Opening bracket
                 . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag
                 . "($tagregexp)"                     // 2: Shortcode name
                 . '(?![\\w-])'                       // Not followed by word character or hyphen
                 . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
                 .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
                 .     '(?:'
                 .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
                 .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
                 .     ')*?'
. ')'
. '(?:'
                 .     '(\\/)'                        // 4: Self closing tag ...
                 .     '\\]'                          // ... and closing bracket
                 . '|'
                 .     '\\]'                          // Closing bracket
                 .     '(?:'
                 .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and sing shortcode tags
                 .             '[^\\[]*+'             // Not an opening bracket
                 .             '(?:'
                 .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
                 .                 '[^\\[]*+'         // Not an opening bracket
                 .             ')*+'
.         ')'
                 .         '\\[\\/\\2\\]'             // Closing shortcode tag
                 .     ')?'
. ')'
                 . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag
               }


               function shortcode_parse_atts($text) {
                 $atts = array();
                 $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
                 $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
                 if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
                   foreach ($match as $m) {
                     if (!empty($m[1]))
                       $atts[strtolower($m[1])] = stripcslashes($m[2]);
                     elseif (!empty($m[3]))
                       $atts[strtolower($m[3])] = stripcslashes($m[4]);
                     elseif (!empty($m[5]))
                       $atts[strtolower($m[5])] = stripcslashes($m[6]);
                     elseif (isset($m[7]) and strlen($m[7]))
                       $atts[] = stripcslashes($m[7]);
                     elseif (isset($m[8]))
                       $atts[] = stripcslashes($m[8]);
                   }
                 } else {
                   $atts = ltrim($text);
                 }
                 return $atts;
               }


               function do_shortcode_tag( $m ) {
         // allow [[foo]] syntax for escaping a tag
                 if ( $m[1] == '[' && $m[6] == ']' ) {
                   return substr($m[0], 1, -1);
                 }

                 $tag = $m[2];
                 $attr = $this->shortcode_parse_atts( $m[3] );

                 if ( isset( $m[5] ) ) {
                 // enclosing tag - extra parameter
                   return $m[1] . call_user_func( array($this,$this->shortcode_tags[$tag]), $attr, $m[5], $tag ) . $m[6];
                 } else {
                 // self-closing tag
                   return $m[1] . call_user_func( array($this,$this->shortcode_tags[$tag]), $attr, null,  $tag ) . $m[6];
                 }
               }



               function parseKeys($w,$replace){
                /*if(!empty($replace['cond'])){
                foreach($replace['cond'] as $k => $cond){
                    $k = str_replace('%%','\%\%',$k);
                    $w = preg_replace('#'.$k.'([a-zA-Z0-9-_.:;,\n\r\s%]+)'.$k.'#i', (($cond)?'$1':''),$w);
                }
              }*/
              $w = str_replace( array_keys($replace['keys']), array_values($replace['keys']),$w);
              return $w;
            }



          }
          ?>