import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {PlayerJob} from "../../class/player-job";
import {Item} from "../../class/item";

@Component({
  selector: 'app-upgrade-player-job',
  templateUrl: './upgrade-player-job.component.html',
  styleUrls: ['./upgrade-player-job.component.scss']
})
export class UpgradePlayerJobComponent implements OnInit {
  @Input() playerJob: PlayerJob;
  @Input() valueRaid : number;
  @Input() playerJobSelectedId: number;
  stuffToUpgrade : any = [];
  stuffToDisabled : any = [];
  itemSelected: number;
  disabled :boolean;
  noNeed: boolean;
  @Input() playerJobSet: number;
  @Input() item: Item;
  @Output() valueChange = new EventEmitter();
  constructor() { }

  ngOnInit(): void {
    this.getStuff();
    if (this.stuffToUpgrade.length === 0){
      this.noNeed = true;
    }
  }
  getStuff(){
    for (let obj in this.playerJob.wishitem){
      if(this.playerJob.wishitem[obj]) {
        if (this.playerJob.wishitem[obj].isUpgraded) {
          if (this.playerJob.currentstuff[obj] && this.playerJob.wishitem[obj].id === this.playerJob.currentstuff[obj].id) {
            let item = new Item();
            item = this.playerJob.wishitem[obj];
            this.stuffToUpgrade.push(item);
          } else {
            let item = new Item();
            item = this.playerJob.wishitem[obj];
            this.stuffToUpgrade.push(item);
            this.stuffToDisabled.push(item);
          }
        }
      }
    }
    if (this.stuffToDisabled.length >= 1) {
      if (this.valueRaid === 2) {
        return this.stuffToUpgrade = this.stuffToUpgrade.filter((item: Item) => {
          return item.slot.id === 6 || item.slot.id >= 9;
        });
      }
      if (this.valueRaid === 3) {
          if(!this.item.slot){
            return this.stuffToUpgrade = this.stuffToUpgrade.filter((item: Item) => {
              return item.slot.id <= 5 || item.slot.id === 7 || item.slot.id === 8;
            });
          }
          if(this.item.slot.id === 1){
            return this.stuffToUpgrade = this.stuffToUpgrade.filter((item: Item) => {
              return item.slot.id === 1;
            });
          }
      }
    }
    if (this.stuffToDisabled.length === 0){
      return this.noNeed = true;
    }
  }
  passArray(){
    this.valueChange.emit(this.stuffToUpgrade);
  }
}
