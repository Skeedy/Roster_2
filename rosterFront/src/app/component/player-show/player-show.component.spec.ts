import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PlayerShowComponent } from './player-show.component';

describe('PlayerShowComponent', () => {
  let component: PlayerShowComponent;
  let fixture: ComponentFixture<PlayerShowComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PlayerShowComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PlayerShowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
