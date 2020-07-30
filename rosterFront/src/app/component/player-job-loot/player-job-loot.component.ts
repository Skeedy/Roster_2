import {Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {PlayerJob} from "../../class/player-job";
import {Item} from "../../class/item";

@Component({
  selector: 'app-player-job-loot',
  templateUrl: './player-job-loot.component.html',
  styleUrls: ['./player-job-loot.component.scss']
})
export class PlayerJobLootComponent implements OnChanges {

  constructor() { }
  @Input() playerJob: PlayerJob;
  @Input() lootSlot: any;
  @Input() playerJobSet: number;
  public playerJobSelectedId : number;
  @Input() playerJobSel :number;
  @Input() slotItemid: number;
  @Input() item: Item;
  disabled :boolean;
  noNeed: boolean;
  @Output() playerJobSelected: EventEmitter<number>= new EventEmitter<number>();
  ngOnChanges(): void {
    this.disabled = false;
    this.noNeed = false;
    this.check();
  }
  setPlayerJob(idPlayerJob){
    this.playerJobSelectedId = idPlayerJob;
    this.playerJobSelected.emit(idPlayerJob);
  }
  check(){
    if(this.item) {
      let slotName = this.item.slot.name;
      if (this.item.isSavage) {
        if (this.playerJob.currentstuff[slotName] && this.playerJob.currentstuff[slotName].slot.id === this.item.slot.id) {
          return this.disabled = true;
        }
        if (this.playerJob.wishitem[slotName] && !this.playerJob.wishitem[slotName].isSavage){
          return this.noNeed = true;
        }
      }
    }
  }
}
