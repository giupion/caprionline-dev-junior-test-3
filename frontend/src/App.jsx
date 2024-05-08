import  { useEffect, useState } from 'react';
import PropTypes from 'prop-types';
import { Button, Rating, Spinner } from 'flowbite-react';

const App = () => {
  const [movies, setMovies] = useState([]);
  const [loading, setLoading] = useState(true);
  const [orderBy, setOrder] = useState('');
  const [genres, setGenres] = useState([]);
  const [filter, setFilter] = useState('');

  const updateOrder = (e) => {
    const selected = e.target.value;
    setOrder(selected);
  };

  const updateFilter = (e) => {
    const selected = e.target.value;
    setFilter(selected);
  };

  const fetchMovies = async () => {
    try {
      setLoading(true);
      let query = '';
      if (orderBy !== '') query += '/' + orderBy;
      if (filter !== '') query = '/' + filter.toLowerCase() + query;
      const response = await fetch('http://localhost:8000/movies' + query);
      if (!response.ok) {
        throw new Error('Failed to fetch movies');
      }
      const data = await response.json();
      setMovies(data);
    } catch (error) {
      console.error('Error fetching movies:', error);
    } finally {
      setLoading(false);
    }
  };

  const fetchGenres = async () => {
    try {
      const response = await fetch('http://localhost:8000/genres');
      if (!response.ok) {
        throw new Error('Failed to fetch genres');
      }
      const data = await response.json();
      setGenres(data);
    } catch (error) {
      console.error('Error fetching genres:', error);
    }
  };

  useEffect(() => {
    if (genres.length === 0) {
      fetchGenres();
    }
    fetchMovies();
  }, [filter, orderBy, genres.length]);

  return (
    <Layout>
      <Heading />
      <Nav genres={genres} updateFilter={updateFilter} updateOrder={updateOrder} />
      <MovieList loading={loading} movies={movies}>
        {movies.map((item, key) => (
          <MovieItem key={key} {...item} />
        ))}
      </MovieList>
    </Layout>
  );
};

App.propTypes = {
  children: PropTypes.node,
};

const Layout = ({ children }) => {
  return (
    <section className="bg-white dark:bg-gray-900">
      <div className="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">{children}</div>
    </section>
  );
};

Layout.propTypes = {
  children: PropTypes.node.isRequired,
};

const Heading = () => {
  return (
    <div className="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
      <h1 className="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
        Movie Collection
      </h1>

      <p className="font-light text-gray-500 lg:mb-16 sm:text-xl dark:text-gray-400">Explore the whole collection of movies</p>
    </div>
  );
};

const Nav = ({ genres, updateFilter, updateOrder }) => {
  return (
    <ul className="flex justify-end mb-4">
      <li className="mr-3">
        <label htmlFor="genres">Choose a Genre:</label>
        <select
          id="genres"
          onChange={updateFilter}
          className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        >
          <option default value="">
            -
          </option>
          {genres.map((item, key) => (
            <option key={key} value={item.name}>
              {item.name}
            </option>
          ))}
        </select>
      </li>
      <li className="mr-3">
        <label htmlFor="order">Order By:</label>
        <select
          id="order"
          onChange={updateOrder}
          className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        >
          <option default value="">
            -
          </option>
          <option value="release">Release</option>
          <option value="rating">Rating</option>
        </select>
      </li>
    </ul>
  );
};

Nav.propTypes = {
  genres: PropTypes.array.isRequired,
  updateFilter: PropTypes.func.isRequired,
  updateOrder: PropTypes.func.isRequired,
};

const MovieList = ({ loading, movies, children }) => {
  if (loading) {
    return (
      <div className="text-center">
        <Spinner size="xl" />
      </div>
    );
  }

  if (movies.length === 0) {
    return <div>No movies found</div>;
  }

  return <div className="grid gap-4 md:gap-y-8 xl:grid-cols-6 lg:grid-cols-4 md:grid-cols-3">{children}</div>;
};

MovieList.propTypes = {
  loading: PropTypes.bool.isRequired,
  movies: PropTypes.array.isRequired,
  children: PropTypes.node,
};

const MovieItem = ({ imageUrl, title, year, rating, plot, wikipediaUrl }) => {
  return (
    <div className="flex flex-col w-full h-full rounded-lg shadow-md lg:max-w-sm">
      <div className="grow">
        <img className="object-cover w-full h-60 md:h-80" src={imageUrl} alt={title} loading="lazy" />
      </div>

      <div className="grow flex flex-col h-full p-3">
        <div className="grow mb-3 last:mb-0">
          {(year || rating) && (
            <div className="flex justify-between align-middle text-gray-900 text-xs font-medium mb-2">
              <span>{year}</span>

              {rating && (
                <Rating>
                  <Rating.Star />

                  <span className="ml-0.5">{rating}</span>
                </Rating>
              )}
            </div>
          )}

          <h3 className="text-gray-900 text-lg leading-tight font-semibold mb-1">{title}</h3>

          <p className="text-gray-600 text-sm leading-normal mb-4 last:mb-0">{plot.substr(0, 80)}...</p>
        </div>

        {wikipediaUrl && (
          <Button color="light" size="xs" className="w-full" onClick={() => window.open(wikipediaUrl, '_blank')}>
            More
          </Button>
        )}
      </div>
    </div>
  );
};

MovieItem.propTypes = {
  imageUrl: PropTypes.string.isRequired,
  title: PropTypes.string.isRequired,
  year: PropTypes.number,
  rating: PropTypes.number,
  plot: PropTypes.string.isRequired,
  wikipediaUrl: PropTypes.string,
};

export default App;
