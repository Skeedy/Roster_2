import {AfterViewInit, Component, EventEmitter, Input, OnChanges, OnDestroy, OnInit, Output} from '@angular/core';
import {Item} from "../../class/item";
import {animate, style, transition, trigger} from "@angular/animations";
import {PlayerJob} from "../../class/player-job";
import {ItemService} from "../../service/item.service";
import {RosterService} from "../../service/roster.service";
import {Player} from "../../class/player";
import {Wishitem} from "../../class/wishitem";
import {WhishitemService} from "../../service/whishitem.service";
import {CurrentstuffService} from "../../service/currentstuff.service";

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
  @Input() currentId: number;
  @Input() isWish: boolean;
  @Input() isCurrentStuff: boolean;
  public player : Player;
  @Input() slotName: string
  @Output() gearShowChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(private wishitemServ: WhishitemService) { }

  ngOnDestroy(): void {
  }
  changeGear(itemId){
      return this.wishitemServ.changeGear(itemId, this.wishId).subscribe(data => {
        this.wishitemServ.refreshWishItem(this.wishId).subscribe();
        this.close();
      })
  }
  close() {
    this.gearShow = false;
    this.gearShowChange.emit(this.gearShow);
  }
}
