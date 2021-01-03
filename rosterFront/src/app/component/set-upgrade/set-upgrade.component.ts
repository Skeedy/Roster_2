import {Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {RosterService} from "../../service/roster.service";
import {animate, style, transition, trigger} from "@angular/animations";
import {Item} from "../../class/item";
import {LootService} from "../../service/loot.service";
import {PlayerJob} from "../../class/player-job";
import {SuccessService} from "../../service/success.service";
import {ErrorService} from "../../service/error.service";
import {LoadingService} from "../../service/loading.service";

@Component({
  selector: 'app-set-upgrade',
  templateUrl: './set-upgrade.component.html',
  styleUrls: ['./set-upgrade.component.scss'],
  animations: [
    trigger('pool', [
      transition('void => *', [
        style({ transform: 'scale3d(.3, .3, .3)' }),
        animate(100)
      ]),
      transition('* => void', [
        animate(100, style({ transform: 'scale3d(.0, .0, .0)' }))
      ])
    ])
  ]
})
export class SetUpgradeComponent implements OnInit, OnChanges {
  @Input() setUpgrade;
  @Input() item: Item;
  @Input() valueRaid: number;
  playerJob: PlayerJob;
  stuffToUpgrade: Item[];
  playerJobSelectedId: number;
  @Input() lootSlot: any;
  itemSet: number;
  playerJobSet: number;
  itemId: number;
  buttonDisabled = true;
  @Output() setUpgradeChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(public successServ: SuccessService, public errorServ: ErrorService, public loadingServ: LoadingService, public rosterServ : RosterService, public lootServ : LootService) { }

  ngOnInit(): void {
  }

  ngOnChanges(){
    if (this.lootSlot) {
      this.itemSet = this.lootSlot.item_upgraded ? this.lootSlot.item_upgraded : '';
      this.playerJobSet = this.lootSlot.playerjob_id ? this.lootSlot.playerjob_id : '';
    }
  }
  close() {
    this.setUpgrade = false;
    this.setUpgradeChange.emit(this.setUpgrade);
    this.itemId = null;
    this.playerJobSelectedId = null;
    this.stuffToUpgrade = null;
    this.buttonDisabled = true;
  }
  getStuff($event, playerJob){
    this.stuffToUpgrade = $event;
    this.playerJob = playerJob;
    this.playerJobSelectedId = playerJob.id;
    this.itemId = null;
    this.buttonDisabled = true;
  }
  getItem($event){
    this.itemId = $event;
    if (this.playerJobSelectedId || this.playerJobSet && this.itemId) {
      this.buttonDisabled = false;
    }
  }
  setItem(){
    this.loadingServ.activeLoading();
    this.lootServ.setItemToUpgrade(this.lootSlot? this.lootSlot.loot_id : null,
      this.item.id, this.playerJobSelectedId, this.valueRaid, this.itemId).subscribe(_=>{
      this.lootServ.refreshWeekLoot().subscribe();
      this.rosterServ.refreshRoster().subscribe();
      this.loadingServ.removeLoading();
      this.successServ.getSuccess('blabla');
      this.close();
    })
  }
}
