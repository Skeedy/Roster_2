import {Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {animate, style, transition, trigger} from "@angular/animations";
import {Item} from "../../class/item";
import {Player} from "../../class/player";
import {LootService} from "../../service/loot.service";
import {RosterService} from "../../service/roster.service";
import {SuccessService} from "../../service/success.service";
import {LoadingService} from "../../service/loading.service";

@Component({
  selector: 'app-pool',
  templateUrl: './pool.component.html',
  styleUrls: ['./pool.component.scss'],
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
export class PoolComponent implements OnInit, OnChanges {
  @Input() raidValue: number;
  @Input() nameRaid: string;
  @Input() poolList: boolean;
  @Input() numberChest: number;
  @Input() itemRaid: Item[];
  @Input() players: Player[];
  @Input() lootSlot: any;
  itemSelected: number;
  @Input() playerJobSet: number;
  playerJobSelected: number;
  itemSet: number;
  slotItemId: number;
  itemObject :Item;
  disabled: boolean;
  html: string;
  error: boolean;
  buttonDisabled = true;
  @Input() lootId : number;
  @Output() poolListChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(public lootServ: LootService,
              public rosterServ: RosterService,
              public successServ: SuccessService,
              public loadingServ: LoadingService) { }

  ngOnInit(){

  }
  ngOnChanges(): void {
    if (this.lootSlot) {
      this.itemSet = this.lootSlot.item_id ? this.lootSlot.item_id : '';
      this.playerJobSet = this.lootSlot.playerjob_id ? this.lootSlot.playerjob_id : '';
    }

  }
  close() {
    this.poolList = false;
    this.poolListChange.emit(this.poolList);
    this.itemSet = null;
    this.playerJobSet = null;
    this.itemSelected = null;
    this.playerJobSelected = null;
    this.error = false;
    this.itemObject = null;
    this.buttonDisabled = true;
  }
  setItem(idItem){
    this.itemSet = idItem;
    this.itemSelected = idItem;
    this.playerJobSelected = null;
    this.buttonDisabled = true;
  }
  getPlayerJob(idPlayerJob : number){
    this.playerJobSelected = idPlayerJob;
    if (this.playerJobSelected || this.playerJobSet && this.itemSelected) {
      this.buttonDisabled = false;
    }
  }
  patchLoot(instanceValue, chest){
    this.loadingServ.activeLoading();
    let playerJobId = this.playerJobSelected? this.playerJobSelected : this.playerJobSet;
      this.lootServ.patchLoot(this.lootId? this.lootId : '', this.itemSet,playerJobId, instanceValue, chest)
        .subscribe(data=> {
          this.lootServ.refreshWeekLoot().subscribe(_=>{
            this.rosterServ.refreshRoster().subscribe(_=>{
              this.loadingServ.removeLoading();
              // @ts-ignore
              this.successServ.getSuccess(data.item.name + ' has been set to ' + data.playerjob.player.name + '\'s ' + data.playerjob.job.name)
              this.close();
            });
          });
        })
    }
}
