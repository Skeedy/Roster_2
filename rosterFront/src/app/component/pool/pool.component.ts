import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {animate, style, transition, trigger} from "@angular/animations";
import {Item} from "../../class/item";
import {Player} from "../../class/player";
import {LootService} from "../../service/loot.service";

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
export class PoolComponent implements OnInit {
  @Input() raidValue: number;
  @Input() nameRaid: string;
  @Input() poolList: boolean;
  @Input() numberChest: number;
  @Input() itemRaid: Item;
  @Input() players: Player[];
  @Input() lootSlot: any;
  isItemSet : boolean;
  isPlayerJobSet: boolean;
  itemSelected: number;
  playerJobSelected: number;
  lootSet = [];
  lootId : number;
  @Output() poolListChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(public lootServ: LootService) { }

  ngOnInit(): void {
    console.log(this.lootSlot)
    if (this.lootSlot) {
      if(this.lootSlot.item_id && this.lootSlot.item_id === this.itemRaid.id) {
        this.isItemSet = true;
      }
      this.lootId = this.lootSlot.loot_id;
      this.lootSet[0] = this.lootSlot.item_id ? this.lootSlot.item_id : '';
      this.lootSet[1] = this.lootSlot.playerjob_id ? this.lootSlot.playerjob_id : '';
    }
  }
  close() {
    this.poolList = false;
    this.poolListChange.emit(this.poolList);
    this.lootSet = [];
  }
  setItem(idItem){
    this.lootSet[0] = idItem;
    this.itemSelected = idItem
  }
  setPlayerJob(idPlayerJob){
    this.lootSet[1] = idPlayerJob;
    this.playerJobSelected = idPlayerJob;
  }
  patchLoot(instanceValue, chest){
    this.lootServ.patchLoot(this.lootId? this.lootId : '', this.lootSet[0] ,this.lootSet[1], instanceValue, chest)
      .subscribe(_=> {
    this.lootSet = []});
    this.lootServ.getWeekLoot().subscribe();
    this.close();

  }
}
