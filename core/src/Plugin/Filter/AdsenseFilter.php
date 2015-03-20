<?php

/**
 * @file
 * Contains \Drupal\adsense\Plugin\Filter\AdsenseFilter.
 */

namespace Drupal\adsense\Plugin\Filter;

use Drupal\adsense\AdBlockInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\block\Entity\Block;

use Drupal\adsense\AdsenseAdBase;

/**
 * Provides a filter for AdSense input tags.
 *
 * @Filter(
 *   id = "filter_adsense",
 *   title = @Translation("AdSense tag"),
 *   description = @Translation("Substitutes an AdSense special tag with an ad. Add this below 'Limit allowed HTML tags'."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE
 * )
 */
class AdsenseFilter extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $patterns = [
      'block'   => '/\[adsense:block:([^\]]+)\]/x',
      'oldtag'  => '/\[adsense:([^:]+):(\d*):(\d*):?(\w*)\]/x',
      'tag'     => '/\[adsense:([^:]+):([^:\]]+)\]/x',
    ];

    foreach ($patterns as $mode => $pattern) {
      if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
          /** @var AdSenseAdBase $ad */
          $ad = '';
          switch ($mode) {
            case 'block':
              // adsense:block:name.
              // Get the block with the same machine name as the tag.
              $module_blocks = \Drupal::entityManager()->getStorage('block')
                                 ->loadByProperties(['id' => $match[1]]);

              /** @var Block $block */
              foreach ($module_blocks as $block) {
                if ($block->getPlugin() instanceof AdBlockInterface) {
                  $ad = $block->getPlugin()->createAd();
                }
              }
              break;

            case 'oldtag':
              // adsense:format:group:channel:slot.
              $ad = AdsenseAdBase::createAd([
                'format' => $match[1],
                'group' => $match[2],
                'channel' => $match[3],
                'slot' => $match[4],
              ]);
              break;

            case 'tag':
              // adsense:format:slot.
              $ad = AdsenseAdBase::createAd([
                'format' => $match[1],
                'slot' => $match[2],
              ]);
              break;
          }
          // Replace the first occurrence of the tag, in case we have the same
          // tag more than once.
          if (isset($ad)) {
            $ad_text = $ad->display();

            $str = '/\\' . $match[0] . '/';
            $text = preg_replace($str, $ad_text, $text, 1);
          }
        }
      }
    }

    $result = new FilterProcessResult($text);

    $result->addAssets(['library' => ['adsense/adsense']]);

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    if ($long) {
      return $this->t('<p>Use tags to define AdSense ads. Examples:</p>
        <ul>
          <li><code>[adsense:<em>format</em>:<em>slot</em>]</code></li>
          <li><code>[adsense:<em>format</em>:<em>[group]</em>:<em>[channel]</em><em>[:slot]</em>]</code></li>
          <li><code>[adsense:block:<em>location</em>]</code></li>
        </ul>');
    }
    else {
      return $this->t('Use the special tag [adsense:<em>format</em>:<em>slot</em>] to display Google AdSense ads.');
    }
  }

}
