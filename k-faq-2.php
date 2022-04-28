<?php

/*
  Plugin Name:  K-FAQ-2
  Plugin URI:
  Description: FAQ formatter
  Author: Ketwaroo D. Yaasir
  Version: 2.0
  Author URI: https://github.com/ketwaroo
 */

add_action('init','k_faq_init',102);

return;

function k_faq_init(){
    
    add_filter('the_content', 'k_faq', 100);
    add_action('wp_head', 'k_faq_head');
    
}

function k_faq_faq(&$p, &$toc, $s = '', $lvl = 1)
{
    $tmp=[];
   $m = '~\[faq([^\]]*?)?]\n?((?:[^[]|\[(?!/?faq([^\]]*?)?])|(?R))+)\n?\[/faq\]~is';

    preg_match_all($m, $p, $tmp);

    $c = count($tmp[0]);
    if ($c)
    {
        $toc .= empty($s) ? '<ul class="k-faq-toc-body">' : '<ul>';
        for ($i = 0; $i < $c;  ++$i)
        {
            $sect       = (empty($s) ? ($i + 1) . '.0' : $s . '.' . ($i + 1));
            $sect_title = htmlentities($tmp[1][$i]);
            $sect_anch  = rawurlencode($sect . ' ' . $tmp[1][$i]);
            $toc        .= '<li><a href="#' . $sect_anch . '">' . $sect . ' ' . $sect_title . '</a>';
            //echo $p;
            if (preg_match($m, $tmp[2][$i])) k_faq_faq($tmp[2][$i], $toc, (empty($s) ? ($i + 1) : $s . '.' . ($i + 1)), ($lvl + 1));

            $p   = str_replace($tmp[0][$i], '<div class="k-faq k-faq-lvl' . $lvl . '"><h3 class="k-faq-head"><a name="' . $sect_anch . '" title="' . $sect_title . '">' . $sect . ' ' . $sect_title . '</a></h3><div class="k-faq-body">' . $tmp[2][$i] . '</div><small class="k-faq-totop"><a href="#faq-toc">[ Back to top ]</a></small></div>', $p);
            $toc .= "</li>";
        }

        $toc .= "</ul>";
    }
}

function k_faq_foot(&$p, &$fn)
{
    $m = '~\[footnote\](.*?)\[/footnote\]~is';
    if (preg_match_all($m, $p, $s))
    {
        $fn  = '<div class="k-footnotes"><h3 class="k-footnote-head">Footnotes</h3><hr class="k-hr" />';
        $c   = 1;
        $cnt = count($s[0]);
        for ($i = 0; $i < $cnt;  ++$i)
        {
            $all   = &$s[0][$i];
            $body  = &$s[1][$i];
            $fn    .= '<div id="footnote-' . $c . '" class="k-footnote"><a name="footnote-' . $c . '" href="#back-' . $c . '" class="k-footnote-ulink">' . $c . '</a><span class="k-footnote-body">' . $body . '</span></div>';
            $backa = '<a href="#footnote-' . $c . '" name="back-' . $c . '" class="k-footnote-dlink">' . $c . '</a>';
            $p     = str_replace($all, $backa, $p);
            ++$c;
        }
        unset($s);
        $fn .= '<hr class="k-hr" /></div>';
    }
}

function k_faq($p)
{
    if (!is_page()) return $p;
    //	$cachekey=md5(substr($p,0,32));
    //
		$toc = '';
    $fn  = '';
    k_faq_faq($p, $toc);
    k_faq_foot($p, $fn);
    return str_replace('[faqtoc]', '<div class="k-faq-toc"><a name="faq-toc"><h3 class="k-faq-toc-head">Contents</h3></a>' . $toc . '</div>', $p) . '' . $fn;
}

function k_faq_head()
{
    if (is_page()) echo '
<style>
.k-faq-lvl1 h3{font-size:1.5em;}
.k-faq-lvl2 h3{font-size:1.333em;}
.k-faq-lvl3 h3{font-size:1.25em;}
.k-faq-lvl4 h3,.k-faq-lvl5 h3,.k-faq-lvl6 h3,.k-faq-lvl7 h3{font-size:1.1em;}
.k-faq{margin:0.125em;}
.k-faq-head{margin-top:0.25em;text-transform:capitalize;margin-bottom:0.2em 0;line-height:1.1em;}
.k-faq-body{text-align:justify;margin-left:1em;padding-left:0.5em;border-left-width:1px;border-left-style:dotted;}
.k-faq-toc{margin-left:2em;margin:bottom:1em;}
.k-faq-toc-head{margin-bottom:0.1em;}
.k-faq-toc-body{margin-left:1em;line-height:1.1em;font-size:1.2em;}
.k-faq-toc-body li{margin:0.1em;margin-left:0.5em;text-transform:capitalize;font-weight:bold;font-size:0.9em;}
.k-hr{margin:0.6em 4.5em;}
.k-faq-totop{display:block;text-align:right;font-size:x-small;}
.k-footnotes{margin:0.5em;margin-left:5em;font-size:x-small;line-height:1em;margin-top:2em;}
.k-footnote{padding:0.25em;line-height:1em;margin-bottom:0.1em;}
.k-footnote-body{font-size:x-small;text-align:justify;}
.k-footnote-ulink{font-weight:bold;float:left;padding:1px;display:block;font-size:small;}
.k-footnote-dlink{vertical-align:super;font-size:x-small;line-height:1em;}
</style>
';
}
