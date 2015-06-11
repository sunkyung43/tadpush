<!--서브메뉴 -->
<div id="SubSide">
	<span class="subTitle"> <?php 
	$parent_menu_name =  isset($this->top_menu_list[$this->top_menu_sq]['MENU_NM']) ? $this->top_menu_list[$this->top_menu_sq]['MENU_NM'] : '';
	echo $parent_menu_name;
	?>
	</span>

	<ul class="subMenu">
		<?php
		if(isset($this->depth2_menu_list[$this->top_menu_sq])):
		{
			foreach ($this->depth2_menu_list[$this->top_menu_sq] as $depth2_row):
			{
				if ($this->depth2_menu_sq == $depth2_row['MENU_SQ']):
				{
					$menu_selected = 'class="selection"';
				}
				else:
				{
					$menu_selected = '';
				}
				endif;

				echo sprintf('<li %s><a href="javascript:location.replace(\'%s\');">%s</a>', $menu_selected, $depth2_row['MENU_URL'], $depth2_row['MENU_NM']);

				// 			if($menu_selected != '')
				{
					if(isset($this->depth3_menu_list[$depth2_row['MENU_SQ']]))
					{
						echo '<ul class="subMenu2dp">';
						foreach ($this->depth3_menu_list[$depth2_row['MENU_SQ']] as $depth3_row)
						{
							if ($this->depth3_menu_sq == $depth3_row['MENU_SQ'])
							{
								$menu_selected = 'class="selection"';
							}
							else
							{
								$menu_selected = '';
							}

							echo sprintf('<li %s><a href="javascript:location.replace(\'%s\');">%s</a></li>', $menu_selected, $depth3_row['MENU_URL'], $depth3_row['MENU_NM']);
						}
						echo '</ul>';
					}
				}

				echo '</li>';
			}
			endforeach;
		}
		endif;
		?>
	</ul>
</div>
