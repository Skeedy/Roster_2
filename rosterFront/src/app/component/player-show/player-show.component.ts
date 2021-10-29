import {AfterViewInit, Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {Player} from "../../class/player";
import {animate, style, transition, trigger} from "@angular/animations";
import {JobService} from "../../service/job.service";
import {Item} from "../../class/item";
import {Observable} from "rxjs";
import {ItemService} from "../../service/item.service";
import {Wishitem} from "../../class/wishitem";
import {WhishitemService} from "../../service/whishitem.service";
import {Currentstuff} from "../../class/currentstuff";
import {CurrentstuffService} from "../../service/currentstuff.service";

@Component({
  selector: 'app-player-show',
  templateUrl: './player-show.component.html',
  styleUrls: ['./player-show.component.scss'],
  animations: [
    trigger('playerShow', [
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
export class PlayerShowComponent implements OnInit {
  @Input() player:Player;
  @Input() items: Item[];
  @Input() wishItem : Wishitem;
  @Input() currentStuff : Currentstuff;
  @Input() closable = true;
  @Input() wishId: number;
  showDialog = false;
  @Input() idMain : number;
  @Input() playerShow: boolean;
  @Output() playerShowChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  public jobItems: any;
  public index = 0;
  wishlistShow = true;
  constructor(public jobServ: JobService,public currenServ: CurrentstuffService ,public wishitemServ: WhishitemService,public itemServ: ItemService) { }

  ngOnInit(): void {
  }

  getGear(jobId, wishId, StuffId){
    if(this.player.playerJobs.length > 0) {
      this.jobServ.getJobStuff(jobId).subscribe(data => {
        this.items = data;
      })
      this.wishitemServ.getWishItem(wishId).subscribe( data => {
        this.wishItem = data;
      })
      this.currenServ.getCurrentItem(StuffId).subscribe( data => {
        this.currentStuff = data;
      })
    }
  }
  close() {
    this.playerShow = false;
    this.playerShowChange.emit(this.playerShow);
    this.index = 0;
  }
}
