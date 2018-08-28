<html>
	<head>
		<title>sanedPHP</title>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<? if(is_dir($TEMPLATE_DIR.'/bootstrap')): ?>
			<link rel="stylesheet" href="<?=$TEMPLATE_DIR?>/bootstrap/css/bootstrap.min.css">
		<? else: ?>
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<? endif; ?>
		<link rel="stylesheet" href="<?=$TEMPLATE_DIR?>/style.css">
	</head>
	<body>
		<div class="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<div class="jumbotron">
							<h1>sanedPHP</h1>
							<form method="post">
                                <input type="hidden" name="op" value="doscan">
								<div class="form-group">
									<label><?=$LANG['device']?></label>
									<select name="device" class="form-control">
										<? foreach($SNDPHP->getScanners() as $item): ?>
											<option value="<?=$item['id']?>" <?=($item['id'] == $_REQUEST['device'])?'selected':''?>><?=$item['vendor']?> <?=$item['model']?></option>
										<? endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<label><?=$LANG['format']?></label>
									<select name="format" class="form-control">
                                        <? foreach($SNDPHP->format as $item): ?>
										    <option value="<?=$item?>" <?=($item == $_REQUEST['format'])?'selected':''?>><?=$item?></option>
                                        <? endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<label><?=$LANG['mode']?></label>
									<select name="mode" class="form-control">
                                        <? foreach($SNDPHP->mode as $item): ?>
                                            <option value="<?=$item?>" <?=($item == $_REQUEST['mode'])?'selected':''?>><?=$LANG[$item]?></option>
                                        <? endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<label><?=$LANG['resolution']?></label>
									<select name="resolution" class="form-control">
                                        <? foreach($SNDPHP->resolution as $item): ?>
                                            <option value="<?=$item?>" <?=($item == $_REQUEST['resolution'])?'selected':''?>>DPI <?=$item?></option>
                                        <? endforeach; ?>
									</select>
								</div>
								<button type="submit" class="btn btn-default"><?=$LANG['doscan']?></button>
                                <a href="./" class="btn btn-default"><?=$LANG['clear']?></a>
							</form>
						</div>
					</div>
					<div class="col-sm-12 col-md-6">
						<div class="card" style="">
                            <? $img = ($_REQUEST['file']) ? $SNDPHP->getPath($_REQUEST['file'], $_REQUEST['format']) : $TEMPLATE_DIR.'/noimg.png'; ?>
							<img class="card-img-top" src="<?=$img?>" alt="Scan image">
                            <? if($_REQUEST['file']): ?>
                                <div class="card-body text-right">
                                    <a href="<?=$SNDPHP->getPath($_REQUEST['file'], $_REQUEST['format'])?>" target="_blank" class="btn btn-primary"><?=$LANG['download']?></a>
                                </div>
                            <? endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>