# k-wp-faq-2

A WordPress plufin building on (`ketwaroo/k-wp-parsedown`)[https://github.com/ketwaroo/k-wp-parsedown].

Allows FAQ style formatting with a dynamic table of content.

A working example of this plugin can be found here: https://nerdontheinter.net/about/privacy/

It doesn't **have** to be a FAQ, but it does allow for some decent structured formattng.

Works best in conjunction with (`ketwaroo/k-wp-faq-2`)[https://github.com/ketwaroo/k-wp-faq-2] and (`ketwaroo/parsedown`)[https://github.com/ketwaroo/parsedown], but what can really cause conflicts here is the built in [Shortcode API]((https://codex.wordpress.org/Shortcode_API). That API was not quite advances enough to handle nested sections.

## Usage

The tags added are

 - `[faqtoc]`
   - Adds Table of Content
 - `[faq Question Text? or Section Header]Answer or body of section.[/faq]`
   - FAQ section.  

For example, in your post body.

```
[faqtoc]

[faq What is 6x9?]

  42. // the answer

    [faq This is a nested section]nested sections are also supported. Not sure how deep this can go. You try it and tell me.[/faq]

  More text.

    [faq Another nested section]foobar[/faq]

[/faq]

[faq Another section]bar foo[/faq]

```


