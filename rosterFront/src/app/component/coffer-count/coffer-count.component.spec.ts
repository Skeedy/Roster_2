import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CofferCountComponent } from './coffer-count.component';

describe('CofferCountComponent', () => {
  let component: CofferCountComponent;
  let fixture: ComponentFixture<CofferCountComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CofferCountComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CofferCountComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
