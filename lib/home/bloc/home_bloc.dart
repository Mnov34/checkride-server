import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:bloc/bloc.dart';
import 'package:equatable/equatable.dart';
import 'package:stream_transform/stream_transform.dart';
import 'package:bloc_concurrency/bloc_concurrency.dart';

import 'package:checkride_mobile/home/home.dart';

part 'home_event.dart';
part 'home_state.dart';

const _bikesLimit = 5;
const throttleDuration = Duration(milliseconds: 100);

/// Fonction pour transformer les événements et les rendre "droppable" avec un throttle
/// TODO Se renseigner sur droppable
EventTransformer<E> throttleDroppable<E>(Duration duration) {
  return (events, mapper) {
    return droppable<E>().call(events.throttle(duration), mapper);
  };
}

/// Bloc pour gérer l'état de la page d'accueil
/// S'occupe de l'événement de fetch avec un throttle pour limiter les appels
class HomeBloc extends Bloc<HomeEvent, HomeState> {
  HomeBloc({required this.httpClient}) : super(const HomeState()) {
    on<BikeFetched>(
      _onBikeFetched,
      transformer: throttleDroppable(throttleDuration),
    );
  }

  final http.Client httpClient;

  Future<void> _onBikeFetched(
      BikeFetched event, Emitter<HomeState> emit) async {
    if (state.hasReachedMax) return;
    try {
      if (state.status == HomeStatus.initial) {
        final bikes = await _fetchBikes();
        return emit(state.copyWith(
          status: HomeStatus.success,
          bikes: bikes,
          hasReachedMax: false,
        ));
      }

      final bikes = await _fetchBikes(state.bikes.length);
      bikes.isEmpty
          ? emit(state.copyWith(hasReachedMax: true))
          : emit(state.copyWith(
              status: HomeStatus.success,
              bikes: List.of(state.bikes)..addAll(bikes),
              hasReachedMax: false,
            ));
    } catch (_) {
      emit(state.copyWith(status: HomeStatus.failure));
    }
  }

  /// Logic to fetch bikes from the <a href="https://api.api-ninjas.com">api-ninja API</a>
  Future<List<Bike>> _fetchBikes([int startIndex = 0, String? brand = 'Kawasaki', String? model = 'Ninja']) async {
    const host = 'api.api-ninjas.com';
    const path = 'v1/motorcycles';
    const String apiKey = '';
    final url = Uri.parse(
        'https://$host/$path/?make=$brand&?model=$model&offset=$startIndex');
    final response = await http.get(
      url,
      headers: {'X-Api-key': apiKey},
    );
    if (response.statusCode == 200) {
      final body = jsonDecode(response.body) as List;
      return body.map((dynamic json) {
        final map = json as Map<String, dynamic>;
        return Bike(
          brand: map['make'],
          model: map['model'],
        );
      }).toList();

    }
    throw Exception('Failed to fetch bikes');
  }
}
