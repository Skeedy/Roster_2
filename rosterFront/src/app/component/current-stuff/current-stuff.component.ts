import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {Item} from "../../class/item";
import {Wishitem} from "../../class/wishitem";
import {Player} from "../../class/player";
import {JobService} from "../../service/job.service";
import {WhishitemService} from "../../service/whishitem.service";
import {ItemService} from "../../service/item.service";
import {CurrentstuffService} from "../../service/currentstuff.service";

@Component({
  selector: 'app-current-stuff',
  templateUrl: './current-stuff.component.html',
  styleUrls: ['./current-stuff.component.scss']
})
export class CurrentStuffComponent implements OnDestroy {

  public jobItems: any;
  gearShow = false;
  @Input() index :number;
  @Input() items : Item[];
  @Input() wishItem : Wishitem;
  @Input() player: Player;
  slotName: string;
  constructor(public currentServ: CurrentstuffService) { }

  ngOnDestroy(): void {
  }

  getSlotStuff(id) {
    this.jobItems = this.items.filter((item:Item)=>{
      return item.slot.id === id && item.ilvl >= 450;
    })
  }
}
