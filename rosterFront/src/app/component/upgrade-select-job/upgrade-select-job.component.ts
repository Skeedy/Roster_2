import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Item} from "../../class/item";
import {PlayerJob} from "../../class/player-job";

@Component({
  selector: 'app-upgrade-select-job',
  templateUrl: './upgrade-select-job.component.html',
  styleUrls: ['./upgrade-select-job.component.scss']
})
export class UpgradeSelectJobComponent implements OnInit {
@Input() stuffToUpgrade: Item;
@Input() itemId: number;
@Input() playerJob: PlayerJob;
@Input() itemSet: number;
@Input() playerJobSet : number;
@Input() lootSlot: any;
@Output() itemSelectedId: EventEmitter<number>= new EventEmitter<number>();

disabled: boolean;
  constructor() { }

  ngOnInit(): void {
    this.checkCurrent()
  }
  checkCurrent() {
    if (this.playerJob.currentstuff[this.stuffToUpgrade.slot.name]) {
      return this.disabled = this.playerJob.currentstuff[this.stuffToUpgrade.slot.name].id === this.stuffToUpgrade.id
    }
  }
  setItem(itemId){
    this.itemSelectedId.emit(itemId);
  }
}
