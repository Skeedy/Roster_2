import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PickUpLootComponent } from './pick-up-loot.component';

describe('PickUpLootComponent', () => {
  let component: PickUpLootComponent;
  let fixture: ComponentFixture<PickUpLootComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PickUpLootComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PickUpLootComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
