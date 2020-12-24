import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {JobService} from "../../service/job.service";
import {WhishitemService} from "../../service/whishitem.service";
import {ItemService} from "../../service/item.service";
import {Item} from "../../class/item";
import {Player} from "../../class/player";
import {Wishitem} from "../../class/wishitem";
import {SuccessService} from "../../service/success.service";

@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.component.html',
  styleUrls: ['./wishlist.component.scss']
})
export class WishlistComponent implements OnInit {

  public jobItems: any;
  gearShow = false;
  @Input() index :number;
  @Input() items : Item[];
  @Input() wishItem : Wishitem;
  @Input() player: Player;
  slotName: string;
  constructor(public jobServ: JobService, public wishitemServ: WhishitemService,public itemServ: ItemService) { }

  ngOnInit(): void {
  }

  getSlotStuff(id) {
    this.jobItems = this.items.filter((item:Item)=>{
      return item.slot.id === id && item.ilvl >= 530;
    })
  }
}
