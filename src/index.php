<?php
# AUTHOR: RICARDO AZZI #
#  CREATED: 13/02/2013   #
require_once($_SERVER["DOCUMENT_ROOT"]."/otlist/plugins/config.php");
$page = new Page();
$sql = new MySql("otlist");
$lista = (int) get("l");
if ($lista == FALSE) {
$lista = 0;
}?>
<table style="width: 885px;" cellspacing="0">
	<thead>
		<tr>
			<th style="width: 35px;"></th>
			<th style="width: 35px;"></th>
			<th style="width: 190px;">Ip / website</th>
			<th style="width: 190px;">Server Name</th>
			<th style="width: 180px;">Propaganda</th>
			<th style="width: 90px; font-size: 11px;">Online / Record</th>
			<th style="width: 80px;">Uptime</th>
			<th style="width: 20px;">EXP</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$servers = $sql->Query("SELECT
			a.idserver, a.idaccount, a.txtname, a.txtpropaganda, a.txtwebsite,
			a.txtip, a.nrpeak, a.txtcountry, a.nrxp, a.nrml, a.nrskills, a.nrloot,
			a.nrtype, b.txttype, a.txtversion, a.txtdescription, c.nronline,
			c.nruptime, c.dtcadastro
			FROM servers a
			INNER JOIN servers_types b ON a.nrtype = b.idtype
			LEFT JOIN servers_online_history c ON a.idserver = c.idserver AND c.iscurrent=1
			WHERE a.isactive=1 ORDER BY c.nronline, a.nrpeak, a.txtwebsite<>'', c.nruptime DESC
			LIMIT $lista , 30");
			//	validação de site:
			//	^(http[s]?://|ftp://)?(www\.)?[a-zA-Z0-9-\.]+\.(com|org|net|mil|edu|ca|co.uk|com.au|gov|br)$
		foreach ($servers as $server) {
			$s = new Server($server);
			echo("
				<tr>
					<td><IMG src='".$s->getFlag()."' /></td>
					<td>[".$s->txtversion."]</td>
					<td>".$s->getLink()."</td>
					<td>".$s->txtname."</td>
					<td>".$s->txtpropaganda."</td>
					<td>".$s->nronline." / ".$s->nrpeak."</td>
					<td uptime='".$s->getUptime()."'>".$s->getUptime("string")."</td>
					<td>".$s->nrxp."x</td>
				</tr>
			");	
		}
		?>
	</tbody>
</table>