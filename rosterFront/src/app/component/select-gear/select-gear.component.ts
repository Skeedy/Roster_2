import {AfterViewInit, Component, EventEmitter, Input, OnChanges, OnDestroy, OnInit, Output} from '@angular/core';
import {Item} from "../../class/item";
import {animate, style, transition, trigger} from "@angular/animations";
import {PlayerJob} from "../../class/player-job";
import {ItemService} from "../../service/item.service";
import {RosterService} from "../../service/roster.service";
import {Player} from "../../class/player";
import {Wishitem} from "../../class/wishitem";
import {WhishitemService} from "../../service/whishitem.service";

@Component({
  selector: 'app-select-gear',
  templateUrl: './select-gear.component.html',
  styleUrls: ['./select-gear.component.scss'],
  animations: [
    trigger('gearShow', [
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
export class SelectGearComponent implements OnDestroy {
  @Input() jobItems: Item[];
  @Input() slotId: number;
  @Input() closable = true;
  @Input() gearShow: boolean;
  @Input() wishId : number;
  @Output() wishItem: Wishitem;
  public player : Player;
  @Output() gearShowChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(private wishitemServ: WhishitemService) { }

  ngOnDestroy(): void {
  }
  changeGear(itemId, wishId){
    return this.wishitemServ.changeGear(itemId, wishId).subscribe(data => {
      this.close(wishId);
    })
  }
  close(wishId) {
    this.gearShow = false;
    this.wishitemServ.refreshWishItem(wishId).subscribe();
    this.gearShowChange.emit(this.gearShow);
  }
}
