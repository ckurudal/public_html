<?php

include 'sistem/baglan.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$ayarlar = $vt->query("SELECT * FROM ayarlar WHERE id = 1")->fetch(PDO::FETCH_ASSOC);

$ilanlar = $vt->query("SELECT * FROM emlak_ilan WHERE durum = 0 ORDER BY eklemetarihi DESC")->fetchAll(PDO::FETCH_ASSOC);
$bloglar = $vt->query("SELECT * FROM blog WHERE durum = 0 ORDER BY tarih DESC")->fetchAll(PDO::FETCH_ASSOC);
$haberler = $vt->query("SELECT * FROM haber WHERE durum = 0 ORDER BY tarih DESC")->fetchAll(PDO::FETCH_ASSOC);
$sayfalar = $vt->query("SELECT * FROM sayfa WHERE durum = 0 ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

header('Content-type: Application/xml; charset="utf8"', true);
echo '<?xml-stylesheet type="text/xsl" href="/sitemap.xslt" ?>';
?>
<urlset
  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xmlns:xhtml="http://www.w3.org/1999/xhtml"
  xsi:schemaLocation="
    http://www.sitemaps.org/schemas/sitemap/0.9
    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<url>
  <loc><?php echo $ayarlar["site_url"]; ?></loc>
  <lastmod><?php echo date('c', time()); ?></lastmod>
  <changefreq>daily</changefreq>
  <priority>1.0000</priority>
</url>

<?php foreach ($ilanlar AS $emlak) { ?>

  <url>
    <loc><?php echo $ayarlar["site_url"]; ?>/<?php echo $emlak["seo"]; ?>-<?php echo $emlak["emlakno"]; ?>-ilan-<?php echo $emlak["id"]; ?></loc>
    <lastmod><?php echo date('c', strtotime($emlak["eklemetarihi"])); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.7000</priority>
  </url>
<?php } ?>

<?php foreach ($bloglar AS $blog) { ?>

  <url>
    <loc><?php echo $ayarlar["site_url"]; ?>/<?=$blog["seo"]; ?>-blog-<?=$blog["id"]; ?></loc>
    <lastmod><?php echo date('c', strtotime($blog["tarih"])); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.5000</priority>
  </url>
<?php } ?>

<?php foreach ($haberler AS $haber) { ?>

  <url>
    <loc><?php echo $ayarlar["site_url"]; ?>/<?=$haber["seo"]; ?>-haber-<?=$haber["id"]; ?></loc>
    <lastmod><?php echo date('c', strtotime($haber["tarih"])); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.5000</priority>
  </url>
<?php } ?>

<?php foreach ($sayfalar AS $sayfa) { ?>
  <url>
    <loc><?php echo $ayarlar["site_url"]; ?>/<?=$sayfa["seo"]; ?>-sayfa-<?=$sayfa["id"]; ?></loc>
    <lastmod><?php echo date('Y-m-d', strtotime('2024-01-01')); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.5000</priority>
  </url>
<?php } ?>

</urlset>

