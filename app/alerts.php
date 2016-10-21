
<?php

class Alerts
{
  protected $m_alerts = Array();

  public function add($value)
  {
    $this->m_alerts[] = $value;
  }

  public function outputList()
  {
    if(!empty($this->m_alerts)):?>
      <ul>
        <li>
          <?=implode('</li><li>', $this->m_alerts);?>
        </li>
      </ul>
    <?php endif;
  }
}
?>
