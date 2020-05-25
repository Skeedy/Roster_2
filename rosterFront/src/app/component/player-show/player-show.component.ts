import {AfterViewInit, Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {Player} from "../../class/player";
import {animate, style, transition, trigger} from "@angular/animations";
import {JobService} from "../../service/job.service";
import {Item} from "../../class/item";
import {Observable} from "rxjs";
import {ItemService} from "../../service/item.service";

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
  @Input() closable = true;
  @Input() playerShow: boolean;
  @Output() playerShowChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  @Input() idMain : number;
  public jobItems: any;
  public slotId: number;
  gearShow = false;
  public index = 0;
  constructor(public jobServ: JobService, public itemServ: ItemService) { }

  ngOnInit(): void {

  }

  getGear(jobId){
    this.jobServ.getJobStuff(jobId).subscribe(data => {
    this.items = data;
    console.log(this.items)
    })
  }

  getSlotStuff(id) {
    if( id !== undefined) {
      this.jobItems = this.items.filter((item: Item) => {
        return item.slot.id === id;
      })
    }
    console.log(this.jobItems);
  }
  close() {
    this.playerShow = false;
    this.playerShowChange.emit(this.playerShow);
  }
}
