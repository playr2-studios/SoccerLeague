<div class='content'>
  <?
  if($this->data['player']->name==''){ ?>
    <h1 class='page-title'>Jogador não encontrado</h1>
  <?
  exit;
  }?>
  <div class='byte'>
    <div class='bit-1 box right'>
  		<div class='box-content player-info'>
          <div class='player-face'>
            <div class='player-body'>
              <div class='player-eyes'></div>
              <div class='player-hair'></div>
              <div class='player-bear'></div>
            </div>
          </div>
          <div class='player-options'>
            <?
            if(!$this->data['player']->__listed()){
              if($_SESSION['SL_club']==$this->data['player']->id_club){?>
                <button id-player='<?=$this->data['player']->id_player?>' type="button" class='sell-player btn btn-medium btn-full btn-light'><img src='<?=$this->tree?>assets/img/icons/money.png' width='16px'>Vender jogador</button>
                <!-- <button id-player='<?=$this->data['player']->id_player?>' type="button" class='reject-offers btn btn-medium btn-full btn-light'><img src='<?=$this->tree?>assets/img/icons/cancel.png' width='16px'>Rejeitar todas ofertas</button> -->
                <button id-player='<?=$this->data['player']->id_player?>' type="button" class='fire-player btn btn-medium btn-full btn-danger'><img src='<?=$this->tree?>assets/img/icons/trash.png' width='16px'>Demitir jogador</button>
                <!-- <button type="button" class='btn btn-medium btn-full btn-light'><img src='<?=$this->tree?>assets/img/icons/sell.png' width='16px'>Definir preço</button> -->
              <?}else{?>
                <!-- <button type="button" class='btn btn-large btn-full btn-success'>Fazer oferta</button> -->
                <button type="button" class='btn btn-medium btn-full btn-light'><img src='<?=$this->tree?>assets/img/icons/search.png' width='16px'> Lista de observação</button>
              <?}
            }else{
              $transfer = $this->data['player']->__listed();
              $startdate = new DateTime($transfer['startdate']);
              $enddate = DateTime::createFromFormat("Y-m-d H:i:s", $transfer['enddate']);
              ?>
              <div class='transferlist'>
                <p><strong>Começou em: <?=$startdate->format('d/m/Y H:i:s');?></strong></p>
                <p><strong>Expira em: <?=$enddate->format('d/m/Y H:i:s');?></strong></p>
                <?echo($transfer['id_bid_club']!=NULL) ? "<p><strong>Comprador:</strong> <span class='tooltip tooltip-effect-1' club='".$transfer['id_bid_club']."'>
                  <span class='tooltip-item'><a href='".$this->treeclub."/".$transfer['id_bid_club']."'>".Club::getClubNameById($transfer['id_bid_club'])."</a></span>
                    <span class='tooltip-content clearfix'>
                        <span class='tooltip-text'>Carregando...</span>
                    </span>
                  </span></p>":'<p><strong>Nenhum Comprador</strong></p>';?>
                <p><strong>Valor:</strong></p>
                <h3>$ <?=number_format($transfer['value'],2,',','.')?></h3>
              </div>
              <h4></h4>
              <?if($SESSION['SL_club']==$this->data['player']->id_club){?>
                <button type="button" class='buy btn btn-large btn-full btn-success'>Fazer oferta</button>
              <?}
            }?>
            <!-- <button type="button" class='btn btn-medium btn-full btn-light'><img src='<?=$this->tree?>assets/img/icons/scout.png' width='16px'>Mandar olheiro</button> -->
          </div>
          <div class='player-profile'>
            <h1><?=$this->data['player']->name?><img src='<?=$this->tree?>assets/img/icons/flags/brazil.png' width="24px"></h1>
            <?
            if($this->data['player']->nickname!=''){ ?>
            <h2>'<?=$this->data['player']->nickname?>' <a href='#'>Mudar apelido</a></h2>
            <? }else{ ?>
              <!-- <h2> <a href='#'>Definir apelido</a></h2> -->
            <? } ?>
            <div class='info'>
              <p><strong>Clube:</strong> <span class="tooltip tooltip-effect-1" club='<?=$this->data['player']->id_club?>'>
                  <span class="tooltip-item"><a href='<?=$this->tree?>club/<?=$this->data['player']->id_club?>'><?=$this->data['player']->clubname?></a></span>
                    <span class="tooltip-content clearfix">
                        <span class="tooltip-text">Carregando...</span>
                    </span>
                </span>
              </p>
              <p><strong>Salário:</strong> $<?=$this->data['player']->wage?></p>
              <p><strong>Idade:</strong> <?=$this->data['player']->age?> anos</p>
              <p><strong>Peso/Altura:</strong>  <?=$this->data['player']->weight?>kg/<?=$this->data['player']->height?>cm</p>
              <p><strong>Índice de Habilidade:</strong> <?=$this->data['player']->skill_index?></p>
              <p><strong>REC:</strong> <?=_rec($this->data['player']->rec, App::url())?></p>
              <p><strong>Status:</strong> <?if($this->data['player']->__injuried()){echo 'Lesionado';}else if($this->data['player']->__suspended()){echo 'Suspenso';}else{echo 'Disponível';}?></p>
            </div>
	       </div>
       </div>
     </div>
      <div class='bit-1 box player-stats'>
        <div class='box-title'>Habilidades</div>
        <div class="box-content">
          <table style='text-align:center' class='table is-striped skills'>
            <thead>
              <tr>
                <th class='phi'><abbr title='Força'>For</abbr></th>
                <th class='phi'><abbr title='Velocidade'>Vel</abbr></th>
                <th class='phi'><abbr title='Resistência'>Res</abbr></th>
                <th class='phi'><abbr title='Salto'>Sal</abbr></th>
                <th class='psi'><abbr title='Empenho'>Emp</abbr></th>
                <th class='psi'><abbr title='Posicionamento'>Pos</abbr></th>
                <th class='psi'><abbr title='Concentração'>Con</abbr></th>
                <th class='psi'><abbr title='Decisão'>Dec</abbr></th>
                <th class='psi'><abbr title='Visão'>Vis</abbr></th>
                <th class='psi'><abbr title='Imprevisibilidade'>Imp</abbr></th>
                <th class='psi'><abbr title='Comunicação'>Com</abbr></th>
              </tr>
            </thead>
            <tbody>
              <td class='phi'><?=$this->data['player']->stamina;?></td>
              <td class='phi'><?=$this->data['player']->speed;?></td>
              <td class='phi'><?=$this->data['player']->resistance;?></td>
              <td class='phi border'><?=$this->data['player']->jump;?></td>
              <td class='psi'><?=$this->data['player']->workrate;?></td>
              <td class='psi'><?=$this->data['player']->positioning;?></td>
              <td class='psi'><?=$this->data['player']->concentration;?></td>
              <td class='psi'><?=$this->data['player']->decision;?></td>
              <td class='psi'><?=$this->data['player']->vision;?></td>
              <td class='psi'><?=$this->data['player']->unpredictability;?></td>
              <td class='psi border'><?=$this->data['player']->communication;?></td>
            </tbody>
            <?
            if($this->data['player']->position[0]['position']=='GK'){?>
            <thead>
              <tr>
                <th class='tec'>H.Man</th>
                <th class='tec'>Aer</th>
                <th class='tec'>Pés</th>
                <th class='tec'>MaM</th>
                <th class='tec'>Ref</th>
                <th class='tec'>Sai</th>
                <th class='tec'>Chu</th>
                <th class='tec'>Arr</th>
                <th colspan="3"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class='tec'><?=$this->data['player']->handling;?></td>
                <td class='tec'><?=$this->data['player']->aerial;?></td>
                <td class='tec'><?=$this->data['player']->foothability;?></td>
                <td class='tec'><?=$this->data['player']->oneanone;?></td>
                <td class='tec'><?=$this->data['player']->reflexes;?></td>
                <td class='tec'><?=$this->data['player']->rushingout;?></td>
                <td class='tec'><?=$this->data['player']->kicking;?></td>
                <td class='tec'><?=$this->data['player']->throwing;?></td>
              </tr>
              <?
              }else{
              ?>
                <thead>
                  <tr>
                    <th class='tec'>Mar</th>
                    <th class='tec'>Des</th>
                    <th class='tec'>Cru</th>
                    <th class='tec'>Pas</th>
                    <th class='tec'>Tec</th>
                    <th class='tec'>B.Con</th>
                    <th class='tec'>Dri</th>
                    <th class='tec'>Lon</th>
                    <th class='tec'>Fin</th>
                    <th class='tec'>Cab</th>
                    <th class='tec'>B.Par</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class='tec'><?=$this->data['player']->marking;?></td>
                    <td class='tec border'><?=$this->data['player']->tackling;?></td>
                    <td class='tec'><?=$this->data['player']->crossing;?></td>
                    <td class='tec'><?=$this->data['player']->pass;?></td>
                    <td class='tec'><?=$this->data['player']->technical;?></td>
                    <td class='tec'><?=$this->data['player']->ballcontrol;?></td>
                    <td class='tec border'><?=$this->data['player']->dribble;?></td>
                    <td class='tec'><?=$this->data['player']->longshot;?></td>
                    <td class='tec'><?=$this->data['player']->finish;?></td>
                    <td class='tec'><?=$this->data['player']->heading;?></td>
                    <td class='tec'><?=$this->data['player']->freekick;?></td>
                  </tr>
                  <?
              }
              ?>
            </tbody>
          </table>
        </div>
  </div>
  <div class='bit-60 box'>
    <div class="box-title">
      Histórico
    </div>
    <div class="box-content">
      <table>
        <thead>
          <tr>
            <th><abbr title='Temporada'>T</abbr></th>
            <th>Clube</th>
            <th><abbr title='Jogos'>J</abbr></th>
            <th><abbr title='Gols'><!--<img src='<?=$this->tree?>assets/img/icons/ball.png' width='18px'>-->G</abbr></th>
            <th><abbr title='Assistências'>A</abbr></th>
            <th><abbr title='Cartões Amarelos'>CA</abbr></th>
            <th><abbr title='Cartões Vermelhos'>CR</abbr></th>
            <th><abbr title='Melhor jogador da partida'>MVP</abbr></th>
            <th><abbr title='Nota média'>N</abbr></th>
          </tr>
        </thead>
        <tbody>
          <? foreach ($this->data['history'] as $history) { ?>
          <tr>
            <td><?=$history->season?></td>
            <td><?=$history->club?></td>
            <td><?=$history->games?></td>
            <td><?=$history->goals?></td>
            <td><?=$history->assists?></td>
            <td><?=$history->yellowcards?></td>
            <td><?=$history->redcards?></td>
            <td><?=$history->mvp?></td>
            <td><?=$history->rating?></td>
          </tr>
          <?
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class='bit-40 box'>
    <div class="box-title">
      Posições
    </div>
    <div class="box-content">
      <div class='field'>
        <div class='field_line forwards'>
          <div class='left_block'></div>
          <div class='center_block'>
            <div class='field_player' player-id='' player-name='' position='fcl' >
              <div class='playershirt forward'></div>

            </div>
            <div class='field_player' player-id='' player-name='' position='fc' >
              <div class='playershirt forward'></div>

            </div>
            <div class='field_player' player-id='' player-name='' position='fcr' >
              <div class='playershirt forward'></div>

            </div>
          </div>
          <div class='right_block'></div>
        </div>
        <div class='field_line off_midfielders'>
          <div class='left_block'>
            <div class='field_player' player-id='' player-name='' position='oml' >
              <div class='playershirt midfielder'></div>

            </div>
          </div>
          <div class='center_block'>
            <div class='field_player' player-id='' player-name='' position='omcl' >
              <div class='playershirt midfielder'></div>

            </div>
            <div class='field_player' player-id='' player-name='' position='omcr' >
              <div class='playershirt midfielder'></div>

            </div>
          </div>
          <div class='right_block'>
            <div class='field_player' player-id='' player-name='' position='omr' >
              <div class='playershirt midfielder'></div>

            </div>
          </div>
        </div>
        <div class='field_line midfielders'>
          <div class='left_block'>
            <div class='field_player' player-id='' player-name='' position='ml' >
              <div class='playershirt midfielder'></div>

            </div>
          </div>
          <div class='center_block'>
            <div class='field_player' player-id='' player-name='' position='mcl' >
              <div class='playershirt midfielder'></div>

            </div>
            <div class='field_player' player-id='' player-name='' position='mc' >
              <div class='playershirt midfielder'></div>

            </div>
            <div class='field_player' player-id='' player-name='' position='mcr' >
              <div class='playershirt midfielder'></div>

            </div>
          </div>
          <div class='right_block'>
            <div class='field_player' player-id='' player-name='' position='mr' >
              <div class='playershirt midfielder'></div>

            </div>
          </div>
        </div>
        <div class='field_line def_midfielders'>
          <div class='left_block'>
            <div class='field_player' player-id='' player-name='' position='dml' >
              <div class='playershirt midfielder'></div>

            </div>
          </div>
          <div class='center_block'>
            <div class='field_player' player-id='' player-name='' position='dmcl' >
              <div class='playershirt midfielder'></div>

            </div>
            <div class='field_player' player-id='' player-name='' position='dmcr' >
              <div class='playershirt midfielder'></div>

            </div>
          </div>
          <div class='right_block'>
            <div class='field_player' player-id='' player-name='' position='dmr' >
              <div class='playershirt midfielder'></div>

            </div>
          </div>
        </div>
        <div class='field_line defenders'>
          <div class='left_block'>
            <div class='field_player' player-id='' player-name='' position='dl' >
              <div class='playershirt defender'></div>

            </div>
          </div>
          <div class='center_block'>
            <div class='field_player' player-id='' player-name='' position='dcl' >
              <div class='playershirt defender'></div>

            </div>
            <div class='field_player' player-id='' player-name='' position='dc' >
              <div class='playershirt defender'></div>

            </div>
            <div class='field_player' player-id='' player-name='' position='dcr' >
              <div class='playershirt defender'></div>

            </div>
          </div>
          <div class='right_block'>
            <div class='field_player' player-id='' player-name='' position='dr' >
              <div class='playershirt defender'></div>

            </div>
          </div>
        </div>
        <div class='field_line goalkeeper'>
          <div class='left_block'></div>
          <div class='center_block'>
            <div class='field_player' player-id='' player-name='' position='gk' >
              <div class='playershirt goalkeeper'></div>

            </div>
          </div>
          <div class='right_block'></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- MODAL SELL -->
<input type="checkbox" id="modal_sell" />
<div class="modal modal-sell">
  <div class="modal-content">
    <div class='form-field'>
      <h2>Vender Jogador</h2>
    </div>
    <form method='post'>
      <div class='form-field'>
        <p><strong class='red'>Um jogador colocado a leilão, não pode ser retirado! Você tem certeza?</strong></p>
      </div>
      <div class='form-field'>
        <label for="description">Nome:</label>
        <input type='hidden' name='sellplayer'>
        <input type="text" name="name" readonly value="<?=$this->data['player']->name?>">
      </div>
      <div class='form-field'>
        <label for="description">Começo do Leilão:</label>
        <input type="text" name="startDate" readonly value="<?=date('d/m/Y H:i:s')?>">
      </div>
      <div class='form-field'>
        <label for="description">Fim do Leilão:</label>
        <input type="text" class='date_time' readonly name="endDate" value="<?$date = new DateTime(); $date->add((new DateInterval('P5D')));echo $date->format('d/m/Y H:i:s')?>">
      </div>
      <div class='form-field'>
        <label for="description">Valor Inicial:</label>
        <input type="text" class='money' name="value" value="<?=($this->data['player']->skill_index*1.5)*10000000?>">
      </div>
      <div class='form-field'>
        <button class='btn btn-success'>Vender</button>
      </div>
    </form>
    <label class="modal-close" for="modal_sell"></label>
  </div>
  <div class='modal-pattern'></div>
</div>
<!-- MODAL buy -->
<?
$transfer = $this->data['player']->__listed();
?>
<input type="checkbox" id="modal_buy" />
<div class="modal modal-buy">
  <div class="modal-content">
    <div class='form-field'>
      <h2>Comprar Jogador</h2>
    </div>
    <form method='post'>
      <div class='form-field'>
        <label for="description">Nome:</label>
        <input type='hidden' name='buyplayer'>
        <input type="text" name="name" disabled value="<?=$this->data['player']->name?>">
      </div>
      <div class='form-field'>
        <label for="description">Fim do Leilão:</label>
        <input type="text" class='date_time' disabled name="endDate" value="<?$date = new DateTime(); $date->add(new DateInterval('P1D'));echo $date->format('d/m/Y H:i:s')?>">
      </div>
      <div class='form-field'>
        <label for="description">Próximo Lance:</label>
        <input type="text" class='money bid' name="value" disabled value="<?$value=(($transfer['value']*4)/100)+$transfer['value'];echo number_format($value,2,',','.')?>">
      </div>
      <div class='form-field'>
        <button type='submit' class='btn btn-success'>Realizar oferta</button>
      </div>
      <div class='form-field'>
        <h3 class='buy-response'></h3>
      </div>
    </form>
    <label class="modal-close" for="modal_buy"></label>
  </div>
  <div class='modal-pattern'></div>
</div>
<script type="text/javascript">
  bear = <?=$this->data['player']->bear;?>;
  eyes = <?=$this->data['player']->eyes;?>;
  body = <?=$this->data['player']->body;?>;
  hair = <?=$this->data['player']->hair;?>;
  physical = <?=$this->data['player']->physical();?>;
  technical = <?=$this->data['player']->technical();?>;
  psychologic = <?=$this->data['player']->psychologic();?>;
  positions = [
    <? foreach ($this->data['player']->position as $position) {
      echo "'".strtolower($position['position']) . strtolower($position['side']) . "',";
    } ?>
  ]
</script>
