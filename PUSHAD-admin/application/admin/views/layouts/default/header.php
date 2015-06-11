<!-- header-->
<div id="header">
	<h1>
		<img src="/web/images/common/logo.gif" alt="Tad" />
	</h1>

	<ul class="topNav">
		<li><strong><?php echo $this->session_role_nm; ?> </strong> <?php echo $this->session_user_id; ?>
		</li>
		<li class="end"><a href="javascript:logout();"><strong>LOGOUT</strong>
		</a></li>
	</ul>

	<hr />

	<div class="gnbArea">
		<ul id="gnb">
			<!-- 대메뉴카테고리 -->
			<?php
			$menu_num = 1;
			$top_menu_size = count($this->top_menu_list);
			foreach ($this->top_menu_list as $row):
			{
				if ($this->top_menu_sq == $row['MENU_SQ']):
				{
					$menu_selected = 'class="selection"';
				}
				else:
				{
					$menu_selected = "";
				}
				endif;

				echo sprintf('<li id="gnb%s" %s onmouseover="javascript:subMenuHandling(%s, \'over\', %s);"><a href="javascript:location.replace(\'%s\');">%s</a></li>', $menu_num, $menu_selected, $menu_num, $top_menu_size, $row['MENU_URL'], $row['MENU_NM']);
					
				$menu_num++;
			}
			endforeach;
			?>
		</ul>

		<!-- 소메뉴카테고리 -->
		<?php 
		$menu_num = 1;
		foreach ($this->top_menu_list as $row):
		{
			if ($this->top_menu_sq == $row['MENU_SQ']):
			{
				$menu_selected = ' style="display:block;"';
			}
			else:
			{
				$menu_selected = ' style="display:none;"';
			}
			endif;

			echo sprintf('<ul id="gnbSub%s" class="SubMenu" %s>', $menu_num, $menu_selected);

			$depth2_menu_size = count($this->depth2_menu_list[$row['MENU_SQ']]);
			$depth2_menu_index = 1;
			foreach ($this->depth2_menu_list[$row['MENU_SQ']] as $row2):
			{
				if ($row2['MENU_SQ'] == $this->depth2_menu_sq):
				{
					if ($depth2_menu_index == $depth2_menu_size):
					{
						$menu_selected = ' class="selection end"';
					}
					else:
					{
						$menu_selected = ' class="selection"';
					}
					endif;
				}
				else:
				{
					if ($depth2_menu_index == $depth2_menu_size):
					{
						$menu_selected = ' class="end"';
					}
					else:
					{
						$menu_selected = '';
					}
					endif;
				}
				endif;
				
				echo sprintf('<li %s><a href="javascript:location.replace(\'%s\');">%s</a></li>', $menu_selected, $row2['MENU_URL'], $row2['MENU_NM']);
				// 					echo sprintf('<li %s><a href="javascript:menuHandling(\'%s\', \'0\');">%s</a></li>', $menu_selected, $row2->MENU_URL, $row2->MENU_NM);

				$depth2_menu_index++;
			}
			endforeach;

			echo '</ul>';
			$menu_num++;
		}
		endforeach;
		?>
	</div>
	<hr />
</div>
